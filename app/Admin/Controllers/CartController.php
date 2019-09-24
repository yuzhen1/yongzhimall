<?php

namespace App\Admin\Controllers;

use App\model\Cart;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CartController extends Controller
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
        $grid = new Grid(new Cart);

        $grid->id('购物车Id');
        $grid->goods_id('商品ID');
        $grid->buy_num('购买数量');
        $grid->user_id('用户ID');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
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
        $show = new Show(Cart::findOrFail($id));

        $show->id('Id');
        $show->goods_id('Goods id');
        $show->buy_num('Buy num');
        $show->user_id('User id');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
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
        $form = new Form(new Cart);

        $form->number('goods_id', 'Goods id');
        $form->number('buy_num', 'Buy num');
        $form->number('user_id', 'User id');
        $form->switch('status', 'Status')->default(1);

        return $form;
    }
}
