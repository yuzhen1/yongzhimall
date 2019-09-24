<?php

namespace App\Admin\Controllers;

use App\model\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
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
        $grid = new Grid(new Order);

        $grid->order_id('订单ID');
        $grid->order_no('订单编号');
        $grid->user_id('用户ID');
        $grid->order_amout('订单总额');
        $grid->pay_status('支付状态');
        $grid->pay_way('支付方式');
        $grid->order_desc('订单备注');
        $grid->status('订单状态');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Order::findOrFail($id));

        $show->order_id('Order id');
        $show->order_no('Order no');
        $show->user_id('User id');
        $show->order_amout('Order amout');
        $show->pay_status('Pay status');
        $show->pay_way('Pay way');
        $show->order_desc('Order desc');
        $show->status('Status');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->number('order_id', 'Order id');
        $form->text('order_no', 'Order no');
        $form->number('user_id', 'User id');
        $form->decimal('order_amout', 'Order amout');
        $form->switch('pay_status', 'Pay status')->default(1);
        $form->switch('pay_way', 'Pay way');
        $form->textarea('order_desc', 'Order desc');
        $form->switch('status', 'Status');

        return $form;
    }
}
