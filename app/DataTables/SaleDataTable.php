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
            ->addColumn('action', function($sale){
                $lang = __('locale.View');
                return "<a href='/sale/show/$sale->id'>$lang</a>";
            })
            ->addColumn('name',function($sale){
                return $sale->material->name;
            })
            ->addColumn('unit',function($sale){
                return $sale->unit->name;
            })
            ->addColumn('bill',function($sale){
                return $sale->bill->serial ?? '';
            })
            ->addColumn('currency',function($sale){
                return $sale->currency->name;
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
                    ->buttons(
                        Button::make('pdf')->addClass('btn btn-outline-primary'),
                        Button::make('print')->addClass('btn btn-outline-primary'),
                        Button::make('excel')->addClass('btn btn-outline-primary'),
                        Button::make('copy')->addClass('btn btn-outline-primary'),
                    );
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
            Column::make('unit')->title(__('locale.Unit')),
            Column::make('cost')->title(__('locale.Cost')),
            Column::make('currency')->title(__('locale.Currency')),
            Column::make('bill')->title(__('locale.Bill')),
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
