<?php

namespace App\Admin\Controllers;

use App\Brand;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BrandController extends Controller
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
        $grid = new Grid(new Brand);

        $grid->brand_id('Brand id');
        $grid->brand_name('Brand name');
        $grid->brand_desc('Brand desc');
        $grid->brand_logo('Brand logo');
        $grid->brand_url('Brand url');
        $grid->brand_show('Brand show');

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
        $show = new Show(Brand::findOrFail($id));

        $show->brand_id('Brand id');
        $show->brand_name('Brand name');
        $show->brand_desc('Brand desc');
        $show->brand_logo('Brand logo');
        $show->brand_url('Brand url');
        $show->brand_show('Brand show');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Brand);

        $form->number('brand_id', 'Brand id');
        $form->text('brand_name', 'Brand name');
        $form->textarea('brand_desc', 'Brand desc');
        $form->text('brand_logo', 'Brand logo');
        $form->text('brand_url', 'Brand url');
        $form->switch('brand_show', 'Brand show');

        return $form;
    }
}
