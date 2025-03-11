<?php

namespace App\DataTables;

use App\Models\Manufacturing;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class ManufacturingDataTable extends DataTable
{
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
            ->addColumn('action', function($manufacturing){
                return view('utils.datatable_options',[
                    'route'=>route('manufacturing.show',$manufacturing->id),
                    'options'=>[]
                ]);
            })
            ->addColumn('material',function($manufacturing){
                return $manufacturing->material?->name ?? __('locale.None'); 
            })
            ->addColumn('inventory',function($manufacturing){
                return $manufacturing->inventory?->name ?? __('locale.None'); 
            })
            ->addColumn('bill',function($manufacturing){
                return $manufacturing->bill?->serial ?? __('locale.None'); 
            })
            ->addColumn('created_at', function ($manufacturing) {
                return $manufacturing->created_at->diffForHumans();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Manufacturing $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Manufacturing $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('manufacturing-table')
            ->addTableClass('table-sm')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('material')->title(__('locale.Material')),
            Column::make('inventory')->title(__('locale.Inventory')),
            Column::make('bill')->title(__('locale.Bill')),
            Column::make('quantity')->title(__('locale.Quantity')),
            Column::make('cost')->title(__('locale.Cost')),
            Column::make('created_at')->title(__('locale.Created at')),
            Column::computed('action')
                ->title(__('locale.Action'))
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
        return 'Manufacturing_' . date('YmdHis');
    }
}
