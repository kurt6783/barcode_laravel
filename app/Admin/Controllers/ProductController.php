<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product as ProductRepo;
use App\Http\Controllers\Controller;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;

class ProductController extends Controller
{

    /**
     * Set Title
     */
    protected $title = '產品';

    /**
     * Set description for following 4 action pages.
     *
     * @var array
     */
    protected $description = [
        'index' => '列表',
        'edit' => '編輯',
    ];

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content->title($this->title)
            ->description($this->description()['index'] ?? trans('admin.index'))
            ->body($this->grid());
    }

    /**
     * Get Title
     *
     * @return array
     */
    protected function title()
    {
        return $this->title;
    }

    /**
     * Get description for following 4 action pages.
     *
     * @return array
     */
    protected function description()
    {
        return $this->description;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return new Grid(new ProductRepo(), function (Grid $grid) {
            $grid->model();

            $grid->column('barcode', '條碼');
            $grid->column('name', '產品名稱');
            $grid->column('url', '圖片')->display(function () {
                if (empty($this->url)) {
                    return '<span class="text-muted">無圖片</span>';
                }
                return "<i class='feather icon-image' style='margin-right: 5px;'></i>檢視照片";
            })->modal(function ($modal) {
                $modal->title($this->name ?? '商品圖片'); // 設定彈窗標題為品名
                $modal->icon('');

                if (empty($this->url)) {
                    return '<div class="p-3 text-center text-muted">尚未上傳商品照片</div>';
                }

                $fullUrl = "https://storage.googleapis.com/barcode-swift/{$this->url}";

                return <<<HTML
                    <div style="text-align: center; padding: 15px;">
                        <img src="{$fullUrl}" style="max-width: 100%; max-height: 500px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.15);" alt="商品圖片" />
                        <div style="margin-top: 10px;">
                            <a href="{$fullUrl}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="feather icon-external-link"></i> 開啟原圖
                            </a>
                        </div>
                    </div>
                    HTML;
            });
            $grid->column('count', '數量');

            $grid->export()->disableExportCurrentPage();

            $grid->scrollbarX();
            $grid->disableFilterButton();
            $grid->disableViewButton();
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableRowSelector();
            $grid->disableRefreshButton();
        });
    }
}
