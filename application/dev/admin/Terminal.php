<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\dev\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\dev\model\page;
use think\Db;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\Output;

/**
 * 内容控制器
 * @package app\cms\admin
 */
class Terminal extends Admin
{
    public function database()
    {
        $this->assign('page_title', '数据库');
        return $this->fetch();
    }

    public function sql_add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['create_time'] = date('Y-m_d H:i:s');
            if (Db::name('dev_database_sql')->data($data)->insert()) {
                $this->success('添加成功',url('sql_list').'?_pop=1');
            } else {
                $this->error('添加失败');
            }
        } else {
            $js = <<<JS
<script>
$(function(){
	$('#main-container').css('min-height', 'auto');
    var val = $('#terminal-query',parent.document).val();
    console.log(val)
    $('#sql_').val(val);
})
</script>
JS;
            return ZBuilder::make('form')
            	->setPageTitle('新增')
				->addText('name', '名称')
				->addTextArea('sql_', 'sql语句')
				->setExtraJs($js)
				->fetch();
        }
    }

    public function sql_list()
    {
        $map = $this->getMap();
        $data = Db::name('dev_database_sql')->where($map)->paginate();
        $js = <<<JS
<script>
$(function(){
    $('.select_sql').click(function() {
      var v=$(this).parents('tr').children('td:eq(2)').children('a').text();
      console.log(v);
      $('#terminal-query',parent.document).val(v);
      $('#terminal-query',parent.document).focus();
      parent.layer.closeAll();
      $('#main-container').css('min-height', 'auto');
    })
})
</script>
JS;

        return ZBuilder::make('table')
          ->hideCheckbox()
          ->setSearch(['name' => '名称', 'sql_' => 'sql'])
          ->addColumns([
            ['id', 'ID'],
            ['name', '名称', 'text.edit'],
            ['sql_', 'sql', 'text.edit'],
            ['right_button', '操作', 'btn']
          ])
          ->addRightButton('custom', ['title' => '选择', 'icon' => 'fa fa-fw fa-play', 'class' => 'btn btn-xs btn-default select_sql'])
          ->addRightButton('edit',['href'=>url('edit',['id'=>'__id__']).'?_pop=1'])
          ->addRightButton('delete')
          ->addTopButton('custom',['title'=>'新增','href'=>url('sql_add').'?_pop=1','class'=>'btn btn-bg btn-info'])
          ->setTableName('dev_database_sql')
          ->setRowList($data)
          ->setExtraJs($js)
          ->fetch();
    }

    public function edit($id='')
    {
        if($this->request->isPost()){
            $data=$this->request->post();
            Db::name('dev_database_sql')->data($data)->update();
            $this->success('修改成功',url('sql_list').'?_pop=1');
        }else{
            $data=Db::name('dev_database_sql')->find($id);
            return ZBuilder::make('form')
        		->setPageTitle('编辑')
				->addHidden('id',$id)
				->addText('name', '名称')
				->addTextArea('sql_', 'sql语句')
				->setFormData($data)
				->fetch();
        }

    }
    public function run_database()
    {
        $query = input('q');
        // $connection = Request::get('c', config('database.default'));
        $connection = config('database.');
        return $this->dispatchQuery($connection, $query);
    }

    protected function dispatchQuery($connection, $query)
    {

        $connection = Db::connect($connection);
        try {
            $logs = [];
            Db::listen(function ($sql, $time, $explain) {
                // 记录SQL
                $logs[] = [
                  'sql' => $sql,
                  'time' => $time,
                ];
            });
            $result = $connection->query(str_replace([';', "\G"], '', $query));
        } catch (\Exception $exception) {
            return $this->renderException($exception);
        }

        $log = current($logs);

        if (empty($result)) {
            return sprintf("<pre>Empty set (%s sec)</pre>\r\n", number_format($log['time'] / 1000, 2));
        }

        $result = json_decode(json_encode($result), true);

        if ($this->contains($query, "\G")) {
            return $this->getDumpedHtml($result);
        }

        return sprintf(
          "<pre>%s \n%d %s in set (%s sec)</pre>\r\n",
          $this->table(array_keys(current($result)), $result),
          count($result),
          count($result) == 1 ? 'row' : 'rows',
          number_format($log['time'] / 1000, 2)
        );
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string $haystack
     * @param  string|array $needles
     * @return bool
     */
    public function contains($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle != '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    protected function table(array $headers, $rows, $style = 'default')
    {
        $output = new StringOutput();

        $table = new Table($output);

        if ($rows instanceof Arrayable) {
            $rows = $rows->toArray();
        }

        $table->setHeaders($headers)->setRows($rows)->setStyle($style)->render();

        return $output->getContent();
    }

    protected function getDumpedHtml($var)
    {
        ob_start();

        vardump($var);

        $content = ob_get_contents();

        ob_get_clean();

        return substr($content, strpos($content, '<pre '));
    }

    protected function renderException(\Exception $exception)
    {
        return sprintf(
          "<blockquote><p class='text-warning'><i class='icon fa fa-warning'></i>&nbsp;&nbsp;&nbsp;%s</p></blockquote>",
          str_replace("\n", '<br />', $exception->getMessage())
        );
    }
}

class StringOutput extends Output
{
    public $output = '';

    public function clear()
    {
        $this->output = '';
    }

    protected function doWrite($message, $newline)
    {
        $this->output .= $message . ($newline ? "\n" : '');
    }

    public function getContent()
    {
        return trim($this->output);
    }
}


