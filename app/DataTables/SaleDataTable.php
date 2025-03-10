<?php

namespace App\DataTables;

use App\Models\Sale;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class SaleDataTable extends DataTable
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
            ->addColumn('action', function ($sale) {
                return view('utils.datatable_options',[
                    'route'=>route('sale.show',$sale->id),
                    'options'=>[]
                ]);
            })
            ->addColumn('client', function ($sale) {
                return $sale->client?->fullName;
            })
            ->addColumn('created_by', function ($sale) {
                return $sale->user?->username;
            })
            ->addColumn('materials', function ($sale) {
                return $sale->materials()?->count();
            })
            ->addColumn('cost', function ($sale) {
                // return $sale->materials()?->sum('cost');
                return $sale->total();
            })
            ->addColumn('bill', function ($sale) {
                return $sale->bill?->serial ?? '';
            })
            ->addColumn('created_at',function($sale){
                return $sale->created_at->diffForHumans();
            })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Sale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sale $model)
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
            ->setTableId('sale-table')
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
            Column::make('client')->title(__('locale.Client')),
            Column::make('materials')->title(__('locale.Materials')),
            Column::make('cost')->title(__('locale.Cost')),
            Column::make('bill')->title(__('locale.Bill')),
            Column::make('created_by')->title(__('locale.User')),
            Column::make('created_at')->title(__('locale.Created at')),
            Column::computed('action')
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
        return 'Sale_' . date('YmdHis');
    }
}
