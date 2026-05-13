{{-- resources/views/partials/tree-node.blade.php --}}
@if(isset($item->sub) && count($item->sub['items']) > 0)
    <li class="menu-item-with-sub mb-1" data-search-node>
        <details class="tree-sub-category" open>
            <summary class="sub-category-title fs-6 text-primary search-text">
	        	<a href="{{ route($fallbackRoute, $item->id) }}" class="item-link text-decoration-none search-text" target="_blank">
	                <span class="search-target">{{ $item->name }} - </span>
	                <span class="text-muted small">({{ count($item->sub['items']) }})</span>
		        </a>
            </summary>
            <ul class="sub-item-list list-unstyled pl-3">
                @foreach($item->sub['items'] as $subItem)
                    @include('utils.tree', ['item' => $subItem, 'fallbackRoute' => $item->sub['route']])
                @endforeach
            </ul>
        </details>
    </li>
@else
    <li class="menu-item fs-6 mb-1" data-search-node>
        <a href="{{ route($fallbackRoute, $item->id) }}" class="item-link text-decoration-nonex search-text" target="_blank">
            <span class="search-target">{{ $item->name }}</span>
        </a>
    </li>
@endif
