<?php

namespace App\DataTables;

use App\Models\InventoryMaterial;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\SearchPane;

class InventoryMaterialDataTable extends DataTable
{
    private $inventory_id;
    public function __construct($id)
    {
        $this->inventory_id = $id;
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($material) {
                return view(
                    'utils.datatable_options',
                    [
                        'route' => route('material.show', $material->material_id),
                        'options' => [
                            [
                                'route' => route('inventory.material.delete',[
                                    'inventory_id' => $material->inventory_id,
                                    'material_id' => $material->material_id,
                                ]),
                                'name' => __('locale.Delete'),
                                'class' => 'text-danger',
                                'icon' => 'fa-trash',
                            ],
                        ]
                    ]
                );
            })
            ->addColumn('name', function ($material) {
                return $material->material->name ?? __('locale.Nothing found');
            })
            ->addColumn('status', function ($material) {
                return $material->status();
            })
            ->addColumn('created_at', function ($material) {
                return $material->created_at->diffForHumans();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\InventoryMaterial $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(InventoryMaterial $model)
    {
        return $model->newQuery()->where('inventory_id', $this->inventory_id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('inventorymaterial-table')
            ->addTableClass('table-sm')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->buttons($this->getBtns());
    }

    public function getBtns()
    {
        $btn_class = 'btn btn-outline-primary btn-sm';
        return [
            Button::make('pdf')->addClass($btn_class),
            Button::make('print')->addClass($btn_class),
            Button::make('excel')->addClass($btn_class),
            Button::make('copy')->addClass($btn_class),
        ];
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name')->title(__('locale.Name')),
            Column::make('quantity')->title(__('locale.Quantity')),
            Column::make('status')->title(__('locale.Status')),
            Column::make('created_at')->title(__('locale.Created at')),
            Column::computed('action')->title(__('locale.Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'InventoryMaterial_' . date('YmdHis');
    }
}
