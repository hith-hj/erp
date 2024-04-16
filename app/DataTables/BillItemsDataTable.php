<?php

namespace App\DataTables;

use App\Models\BillItem;
use App\Models\Purchase;
use App\Models\Sale;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class BillItemsDataTable extends DataTable
{
    private $type;
    private $bill;
    public function __construct($bill)
    {
        $this->bill = $bill;
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
            ->addColumn('action', function($item){
                if($item->bill->status ==0){
                    $type = $item->type == 1 ? 'purchase':'sale';
                    return "<a href='/bill/$item->bill_id/$type/$item->id/delete'>delete</a>";
                }
            })
            ->addColumn('material',function($item){
                return $item->material->name;
            })
            ->addColumn('inventory',function($item){
                return $item->inventory->name;
            })
            ->addColumn('unit',function($item){
                return $item->unit->name;
            })
            ->addColumn('currency',function($item){
                return $item->currency->name;
            })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BillItem $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = $this->getModelType();
        return $model->newQuery()->where('bill_id',$this->bill->id);
    }

    private function getModelType()
    {
        return match($this->bill->type){
            1=>new Purchase(),
            2=>new Sale(),
            default=>new Purchase(),
        };
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('billitems-table')
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
            Column::make('inventory')->title(__('locale.Inventory')),
            Column::make('material')->title(__('locale.Material')),
            Column::make('quantity')->title(__('locale.Quantity')),
            Column::make('cost')->title(__('locale.Cost')),
            Column::make('currency')->title(__('locale.Currency')),
            Column::make('account')->title(__('locale.Account')),
            $this->bill->type == 1 ?
            Column::make('vendor')->title(__('locale.Vendor')):
            Column::make('client')->title(__('locale.Client')),
            Column::computed('action')
                  ->title(__('locale.Action'))
                  ->exportable(false)
                  ->printable(false)
                  ->width(20)
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
        return 'BillItems_' . date('YmdHis');
    }
}
