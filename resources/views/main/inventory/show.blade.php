@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Inventory') .' - '. $inventory->name }}
@endsection

@section('content')
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger m-1">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li class="p-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <div class="row">
                <h4>{{__('locale.Add')}} {{__('locale.Material')}}</h4>
                <form method="POST" action="{{route('inventory.material.store',['inventory_id'=>$inventory->id])}}">
                  @csrf
                  <div class="col-12">
                      <div class="row">
                          <div class="col-4">
                              <div class="mb-1">
                                  <label class="form-label" for="phone_number">{{ __('locale.Materials') }}</label>
                                  <select id="material_list" tabindex="2"required class=" form-select">
                                      <option value="">Chose Material</option>
                                      @foreach ($materials as $material)
                                          <option value="{{ $material->id }}">
                                              {{ $material->name }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="mb-1">
                                  <label class="form-label" for="phone_number">{{ __('locale.Quantity') }}</label>
                                  <input type="number" id="material_quantity"
                                      class="form-control @error('quantity') border-danger @enderror"
                                      placeholder="{{ __('locale.Quantity') }}" required tabindex="3" />
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="mb-1">
                                  <label class="form-label" for="phone_number">{{ __('locale.Add') }}</label>
                                  <span id="addMaterialBtn" class="btn btn-primary w-100" onclick="addMaterial(event)">
                                      {{ __('locale.Add')}}{{__('locale.Material') }}
                                  </span>
                              </div>
                          </div>
                      </div>

                      <div id="materials" class="hidden my-1 row mx-0">
                          <div class="col-1 p-1 border">
                              id
                          </div>
                          <div class="col-5 p-1 border">
                              {{ __('locale.Material') }} name
                          </div>
                          <div class="col-5 p-1 border">
                              {{ __('locale.Material') }} quantity
                          </div>
                          <div class="col-1 p-1 border">
                              options
                          </div>
                      </div>
                  </div>
                  <div class="">
                    <button id="storeMaterialBtn"  type="submit" class="btn btn-outline-primary w-100 disabled">{{__('locale.Store')}}</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>{{__('locale.Materials')}}</h4></div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section id="card-content-types">
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ $inventory->name }}</h4>

                        <div class="btn-group">
                            <i id="cardDropDown" data-bs-toggle="dropdown" data-feather="more-vertical"
                                class="font-medium-3 cursor-pointer dropdown-toggle"></i>
                            <div class="dropdown-menu" aria-labelledby="cardDropDown">
                                <a href="{{ url('user/show', ['id' => 1]) }}" class="dropdown-item">owner</a>
                                <a href="{{ url('section/show', ['id' => 1]) }}"class="dropdown-item">Section</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-subtitle text-muted">
                            {{ $inventory->created_at->diffForHumans() }}
                            |
                            {{ $inventory->status() }}
                        </div>
                        <ul class="list-group list-group-flush">

                            @forelse($inventory->materials as $unit)
                                <li class="list-group-item">
                                    Material Name: {{ $unit->name }}
                                    Material Quantity: {{ $unit->pivot->quantity }}
                                </li>
                            @empty
                                <li class="list-group-item ">
                                    No Materials Found
                                </li>
                            @endforelse
                        </ul>
                        <a href="{{ url('card/show', ['id' => $inventory->id]) }}" class="card-link">Edit</a>
                        <a href="{{ url('card/show', ['id' => $inventory->id]) }}"
                            class="card-link color-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
      let material = document.querySelector("#material_list");
      let quantity = document.querySelector("#material_quantity");
      let materials_div = document.querySelector("#materials");
      let storeBtn = document.querySelector("#storeMaterialBtn");
      let addBtn = document.querySelector("#addMaterialBtn");
  
      function addMaterial(event) {
          if (material.selectedIndex == 0 || quantity.value == 0) {
              return;
          }
          materials_div.classList.remove('hidden');
          let id = displayMaterial();
          addInput(id);
          storeBtn.classList.remove('disabled');
          storeBtn.classList.remove('btn-outline-primary');
          storeBtn.classList.add('btn-primary');
          addBtn.classList.remove('btn-primary');
          addBtn.classList.add('btn-outline-primary');
      }
  
      function addInput(id) {
          let div = document.querySelector(`#${id}`);
          let input_id = 'matInp_' + material.selectedIndex;
          if (document.querySelector("#" + input_id) != null) {
              let input = document.querySelector("#" + input_id);
              input.value = quantity.value;
              return;
          }
          let input = document.createElement('input');
          input.id = input_id
          input.type = 'hidden';
          input.name = "materials[" + material.options[material.selectedIndex].value + "]";
          input.value = quantity.value;
          div.appendChild(input);
      }
  
      function displayMaterial() {
          let matDiv_id = 'matDiv_' + material.selectedIndex;
          if (document.querySelector("#quantity_" + matDiv_id) != null) {
              let matDiv = document.querySelector("#quantity_" + matDiv_id);
              matDiv.textContent = quantity.value;
              return;
          }
          let parent = document.createElement('div')
          parent.id = matDiv_id;
          parent.setAttribute('class', 'col-12 row mx-0 p-0')
  
          let id_div = document.createElement('div');
          let name_div = document.createElement('div');
          let quantiy_div = document.createElement('div');
          let delete_div = document.createElement('div');
  
          id_div.setAttribute('class', 'col-1 p-1 border');
          name_div.setAttribute('class', 'col-5 p-1 border');
          quantiy_div.setAttribute('class', 'col-5 p-1 border');
          quantiy_div.setAttribute('id', 'quantity_' + matDiv_id);
          delete_div.setAttribute('class', 'col-1 p-1 border');
  
          id_div.textContent = material.selectedIndex
          name_div.textContent = material.options[material.selectedIndex].text;
          quantiy_div.textContent = quantity.value;
          delete_div.textContent = 'delete';
          delete_div.setAttribute('onclick', 'deleteMaterial(' + material.selectedIndex + ')');
  
          parent.appendChild(id_div);
          parent.appendChild(name_div);
          parent.appendChild(quantiy_div);
          parent.appendChild(delete_div);
          materials_div.appendChild(parent);
          console.log(matDiv_id);
          return matDiv_id;
      }
  
      function deleteMaterial(id) {
          console.log(id);
          let div = document.querySelector("#matDiv_" + id);
          let input = document.querySelector("#matInp_" + id);
  
          // div.replaceChildren();
          while (div.hasChildNodes()) {
              div.removeChild(div.firstChild);
          }
          input.remove();
          div.remove();
      }
  </script>
@endpush
