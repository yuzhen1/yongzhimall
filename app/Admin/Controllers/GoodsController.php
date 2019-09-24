<?php

namespace App\Admin\Controllers;

use App\Goods;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Goods);

        $grid->goods_id('商品ID');
        $grid->goods_name('商品名称');
        $grid->goods_price('商品价格');
        $grid->goods_show('是否展示');
        $grid->goods_new('是否新品');
        $grid->goods_best('是否精品');
        $grid->goods_hot('是否热卖');
        $grid->goods_num('商品库存');
        $grid->goods_img('商品图片')->image();
        $grid->goods_desc('商品详情');
        $grid->cate_id('分类ID');
        $grid->brand_id('品牌ID');
        $grid->create_time('添加时间');
        $grid->status('状态');


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Goods::findOrFail($id));

        $show->goods_id('Goods id');
        $show->goods_name('Goods name');
        $show->goods_price('Goods price');
        $show->goods_show('Goods show');
        $show->goods_new('Goods new');
        $show->goods_best('Goods best');
        $show->goods_hot('Goods hot');
        $show->goods_num('Goods num');
        $show->goods_img('Goods img');
        $show->goods_desc('Goods desc');
        $show->cate_id('Cate id');
        $show->brand_id('Brand id');
        $show->create_time('Create time');
        $show->status('Status');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Goods);

        $form->number('goods_id', '商品ID');
        $form->text('goods_name', '商品名称');
        $form->decimal('goods_price', '商品价格');
        $form->switch('goods_show', '是否展示');
        $form->switch('goods_new', '是否新品')->default(2);
        $form->switch('goods_best', '是否精品')->default(2);
        $form->switch('goods_hot', '是否热卖')->default(2);
        $form->number('goods_num', '商品库存');
        $form->text('goods_img', '商品图片');
        $form->textarea('goods_desc', '商品详情');
        $form->number('cate_id', '分类ID');
        $form->number('brand_id', '品牌ID');
        $form->number('create_time', '添加时间');
        $form->switch('status', 'Status')->default(1);

        return $form;
    }
}
