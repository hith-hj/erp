<?php

namespace App\DataTables;

use App\Models\Material;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MaterialDataTable extends DataTable
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
            ->addColumn('action', function($material){
                $lang = __('locale.View');
                return "<a href='show/$material->id'>$lang</a>";
            })
            ->setRowAttr([
                'id'=>function($material) {
                    return 'row-' . $material->id;
                },
                'class'=>function ($material){
                    return $material->type == 'base' ? 'border border-info':'border border-warning';
                }
            ])
            ->addColumn('units',function($material){
                return count($material->units);
            })
            ->addColumn('type',function($material){
                return $material->type();
            })
            ->addColumn('created_at',function($material){
                return $material->created_at;
            })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Material $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Material $model)
    {
        return $model->newQuery()->with('units');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('materials-table')
                    ->setTableAttribute('class','table datatables-basic')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->buttons(
                        Button::make('pdf')->addClass('btn btn-outline-primary'),
                        Button::make('print')->addClass('btn btn-outline-primary'),
                        Button::make('excel')->addClass('btn btn-outline-primary'),
                        Button::make('copy')->addClass('btn btn-outline-primary'),
                    )
                    ;
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
            Column::make('type')->title(__('locale.Type')),
            Column::make('units')->title(__('locale.Units')),
            Column::make('created_at')->title(__('locale.Created at')),
            Column::computed('action')
                  ->title(__('locale.Action'))
                  ->exportable(false)
                  ->printable(false)
                  ->orderable(false)
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
        return 'Material_' . date('YmdHis');
    }

}
