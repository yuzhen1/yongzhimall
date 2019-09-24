<?php

namespace App\Admin\Controllers;

use App\model\Address;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class AddressController extends Controller
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
        $grid = new Grid(new Address);

        $grid->id('Id');
        $grid->order_id('Order id');
        $grid->user_id('User id');
        $grid->name('Name');
        $grid->tel('Tel');
        $grid->city('City');
        $grid->address('Address');
        $grid->mail('Mail');
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
        $show = new Show(Address::findOrFail($id));

        $show->id('Id');
        $show->order_id('Order id');
        $show->user_id('User id');
        $show->name('Name');
        $show->tel('Tel');
        $show->city('City');
        $show->address('Address');
        $show->mail('Mail');
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
        $form = new Form(new Address);

        $form->number('order_id', 'Order id');
        $form->number('user_id', 'User id');
        $form->text('name', 'Name');
        $form->text('tel', 'Tel');
        $form->text('city', 'City');
        $form->text('address', 'Address');
        $form->email('mail', 'Mail');

        return $form;
    }
}
