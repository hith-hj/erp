@extends('layouts/contentLayoutMaster')

@section('title'){{__('locale.Home Page')}}@endsection
@section('page-style')
<style>
	mark.tree-highlight {
    background-color: #ffeb3b; /* Vibrant Material Yellow */
    color: #000000;
    padding: 0 2px;
    border-radius: 2px;
    font-weight: bold;
}
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-3 p-12 flex ">
		<button class="btn btn-sm btn-flat-primary w-100 fs-1"
                data-bs-toggle="modal" data-bs-target="#showTree">
            	{{-- <i class="fs-1 ficon" data-feather="list" ></i>  --}}
            	{{__('locale.Show Tree')}}
        </button>
        <div class="modal fade" id="showTree" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header row px-0 mx-0 w-full ">
                        <div class="col-6 modal-title">
                        	<h4 class="font-lg">
                                {{__('locale.Components Tree')}}
                            </h4>
                        </div>
					    <div class="col-6">
					        <input type="text" id="treeSearchInput" class="form-control" placeholder="Search items">
					    </div>
                    </div>

                    <div class="modal-body d-flex flex-column" style="min-height:400px; max-height: 500px;">
					    <div class="tree-menu overflow-auto flex-grow-1" id="recursiveTreeMenu">
					        @forelse(App\Helpers\Helper::getTreeData() as $key => $value)
					            <details class="tree-category fs-4 mb-1" data-search-node>
					                <summary class="category-title fs-5 font-weight-bold">
					                    <span class="search-targetx"> {{ ucfirst(__("locale.$key")) }} - </span>
					                    <span class="badge text-success">{{ count($value['data']) }}</span>
					                </summary>

					                <ul class="item-list list-unstyledx">
					                    @forelse($value['data'] as $item)
					                        @include('utils.tree', ['item' => $item, 'fallbackRoute' => $value['route']])
					                    @empty
					                        <li class="empty-msg fs-6 text-muted">No items available</li>
					                    @endforelse
					                </ul>
					            </details>
					        @empty
					            <h2 class="fs-5 text-center mt-3">Tree is empty</h2>
					        @endforelse
					    </div>
					</div>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection

@section('page-script')
<script>
	document.getElementById('treeSearchInput').addEventListener('input', function (e) {
	    const filterText = e.target.value.trim();
	    const cleanFilter = filterText.toLowerCase();
	    const treeContainer = document.getElementById('recursiveTreeMenu');
	    const nodes = Array.from(treeContainer.querySelectorAll('[data-search-node]'));
	    const searchTargets = treeContainer.querySelectorAll('.search-target');

	    // 1. Initialize and cache original text strings
	    searchTargets.forEach(target => {
	        if (!target.hasAttribute('data-original-text')) {
	            target.setAttribute('data-original-text', target.textContent);
	        }
	    });

	    if (!filterText) {
	        // Reset state: remove all highlights, restore text, hide/show details
	        searchTargets.forEach(target => {
	            target.textContent = target.getAttribute('data-original-text');
	        });
	        nodes.forEach(node => {
	            node.style.display = '';
	            if (node.tagName === 'DETAILS') {
	                node.removeAttribute('open');
	            }
	        });
	        return;
	    }

	    const escapedFilter = filterText.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
	    const regex = new RegExp(`(${escapedFilter})`, 'gi');

	    // First Pass: Apply highlight styles to matching targets
	    searchTargets.forEach(target => {
	        const originalText = target.getAttribute('data-original-text');
	        if (originalText.toLowerCase().includes(cleanFilter)) {
	            target.innerHTML = originalText.replace(regex, '<mark class="tree-highlight">$1</mark>');
	        } else {
	            target.textContent = originalText;
	        }
	    });

	    // Reset visibility before executing calculations
	    nodes.forEach(node => {
	        node.style.display = 'none';
	        if (node.tagName === 'DETAILS') {
	            node.removeAttribute('open');
	        }
	    });

	    // Second Pass: Process from the deepest child nodes upward
	    // Reversing the array ensures children validate visibility rules before their parent wrappers do
	    nodes.slice().reverse().forEach(node => {
	        let targetsInNode = node.querySelectorAll('.search-target');
	        let textMatches = false;

	        // Check if this specific node contains the matched text
	        targetsInNode.forEach(target => {
	            if (target.getAttribute('data-original-text').toLowerCase().includes(cleanFilter)) {
	                textMatches = true;
	            }
	        });

	        // Check if any sublists or child layers within this node are visible
	        let hasVisibleChildren = false;
	        const directChildren = node.querySelectorAll('[data-search-node]');
	        directChildren.forEach(child => {
	            if (child.style.display !== 'none') {
	                hasVisibleChildren = true;
	            }
	        });

	        // A node should stay visible if its own text matches OR it has a visible child matching the query
	        if (textMatches || hasVisibleChildren) {
	            node.style.display = '';

	            // If it is a container details block holding valid search matches, auto-expand it
	            if (node.tagName === 'DETAILS' || node.querySelector('details')) {
	                const detailsElements = node.tagName === 'DETAILS' ? [node] : node.querySelectorAll('details');
	                detailsElements.forEach(det => det.setAttribute('open', 'true'));
	            }

	            // Explicitly force parent element chains up to the root to remain visible
	            let ancestor = node.parentElement.closest('[data-search-node]');
	            while (ancestor && treeContainer.contains(ancestor)) {
	                ancestor.style.display = '';
	                if (ancestor.tagName === 'DETAILS') {
	                    ancestor.setAttribute('open', 'true');
	                }
	                ancestor = ancestor.parentElement.closest('[data-search-node]');
	            }
	        }
	    });
	});
</script>
@endsection
