<?php

namespace App\DataTables;

use App\Models\Cashier;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class CashierDataTable extends DataTable
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
            ->addColumn('action', function ($cashier) {
                return view('utils.datatable_options', [
                    'route' => route('cashier.show', $cashier->id),
                    'options' => [
                        [
                            'route' => route('ledger.show',['cashier_id'=>$cashier->id]),
                            'name' => __('locale.Ledger'),
                        ],
                    ],
                ]);
            })
            ->addColumn('is_default', function ($cashier) {
                return $cashier->is_default == 1 ? __('locale.Default') : '-';
            })
            ->addColumn('created_at', function ($cashier) {
                return $cashier->created_at->diffForHumans();
            })
        ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Cashier $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Cashier $model)
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
            ->setTableId('cashier-table')
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
            Column::make('name')->title(__('locale.Name')),
            Column::make('total')->title(__('locale.Total')),
            Column::make('is_default')->title(__('locale.Is Default')),
            Column::make('created_at')->title(__('locale.Created at')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->title(__('locale.Options')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Cashier_' . date('YmdHis');
    }
}
