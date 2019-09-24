<?php

namespace App\Admin\Controllers;

use App\UserModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
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

    public function update($id)
    {

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
        $grid = new Grid(new UserModel);

        $grid->user_id('User id');
        $grid->user_name('User name');
        $grid->email('Email');
        $grid->password('Password');
        $grid->add_time('Add time');
        $grid->last_error_time('Last error time');
        $grid->error_num('Error num');

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
        $show = new Show(UserModel::findOrFail($id));

        $show->user_id('User id');
        $show->user_name('User name');
        $show->email('Email');
        $show->password('Password');
        $show->add_time('Add time');
        $show->last_error_time('Last error time');
        $show->error_num('Error num');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserModel);

        $form->number('user_id', 'User id');
        $form->text('user_name', 'User name');
        $form->email('email', 'Email');
        $form->password('password', 'Password');
        $form->number('add_time', 'Add time');
        $form->number('last_error_time', 'Last error time');
        $form->number('error_num', 'Error num');

        return $form;
    }
}
