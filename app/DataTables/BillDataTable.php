<?php

namespace App\DataTables;

use App\Models\Bill;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class BillDataTable extends DataTable
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
            ->addColumn('action', function($bill){
                $lang = __('locale.View');
                return "<a href='/bill/show/$bill->id'>$lang</a>";
            })
            ->addColumn('type', function($bill){
                return $bill->get_type;
            })
            ->addColumn('status', function($bill){
                return $bill->get_status;
            })
            ->addColumn('items', function($bill){
                return $bill->items()->count();
            })
            ->addColumn('cost', function($bill){
                $total = 0;
                foreach( $bill->items as $item){
                    $total += $item->cost;
                }
                return $total;
            })
            ->setRowId(function($bill){
                return $bill->id;
            })
            
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Bill $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bill $model)
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
                    ->setTableId('bill-table')
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
            Column::make('serial')->title(__('locale.Serial')),
            Column::make('type')->title(__('locale.Type')),
            Column::make('status')
                ->searchable()
                ->orderable()
                ->title(__('locale.Status')),
            Column::make('items')->title(__('locale.Items')),
            Column::make('cost')->title(__('locale.Cost')),
            Column::make('created_at')->title(__('locale.Created at')),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
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
        return 'Bill_' . date('YmdHis');
    }
}
