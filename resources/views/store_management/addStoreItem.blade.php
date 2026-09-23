@php
  $classType = Helper::classType();
  $getSetting = Helper::getSetting();
@endphp
@extends('layout.app') 
@section('content')

<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">
            
            <div id="dynamicAlertContainer">
                <div class="alert alert-custom-danger d-none shadow-sm" id="lowStockBanner">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-exclamation-circle alert-icon mr-2"></i>
                        <div>
                            <strong>Low stock alert:</strong> <span id="lowStockItemsList"></span> — please restock soon.
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-custom-warning d-none shadow-sm" id="reservedStockBanner">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-clock-o alert-icon mr-2"></i>
                            <div>
                                <strong>Reserved stock:</strong> <span id="reservedItemsList"></span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-warning text-dark font-weight-bold ml-auto mt-1 mt-md-0 px-2" id="triggerReleaseBtn">
                            <i class="fa fa-unlock mr-1"></i> Release Holds (>30 mins)
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-lg-3 col-6 mb-2">
                    <div class="small-box bg-info elevation-1 compact-metric-box">
                        <div class="inner">
                            <h3 class="metric-num">{{ !empty($data) ? count($data) : 0 }}</h3>
                            <p class="metric-lbl">Total Registered Items</p>
                        </div>
                        <div class="icon-compact"><i class="fa fa-cubes"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-2">
                    <div class="small-box bg-danger elevation-1 compact-metric-box">
                        <div class="inner">
                            <h3 class="metric-num" id="lowStockMetricCount">0</h3>
                            <p class="metric-lbl">Low Stock Items Alert</p>
                        </div>
                        <div class="icon-compact"><i class="fa fa-exclamation-triangle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-2">
                    <div class="small-box bg-warning elevation-1 compact-metric-box">
                        <div class="inner">
                            <h3 class="metric-num" id="reservedMetricCount">0</h3>
                            <p class="metric-lbl">Active Reserved Units</p>
                        </div>
                        <div class="icon-compact"><i class="fa fa-clock-o"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-2">
                    <div class="small-box bg-success elevation-1 compact-metric-box">
                        <div class="inner">
                            @php
                                $totalRev = 0;
                                if(!empty($data)) {
                                    foreach($data as $item) { $totalRev += (($item->rate ?? 0) * ($item->sold_qty ?? 0)); }
                                }
                            @endphp
                            <h3 class="metric-num">₹{{ number_format($totalRev, 2) }}</h3>
                            <p class="metric-lbl">Total Store Revenue</p>
                        </div>
                        <div class="icon-compact"><i class="fa fa-money"></i></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">     
                    <div class="card card-outline card-primary elevation-2">
                        
                        <div class="card-header d-flex p-0 align-items-center">
                            <h6 class="card-title p-2">
                                <i class="fa fa-university mr-1 ml-1 text-primary"></i> 
                                <strong>{{ __('Stationery & Store Inventory') }}</strong>
                            </h6>
                            <div class="ml-auto p-2">
                                <a href="{{ url('store-daily-collection') }}" class="btn btn-default btn-sm text-bold" title="Back">
                                    <i class="fa fa-bar-chart-o text-muted mr-1"></i> {{ __('Daily Collection') }}
                                </a>
                                <a href="{{ url('addStationaryRequest') }}" class="btn btn-default btn-sm text-bold" title="Back">
                                    <i class="fa fa-plus-circle text-muted mr-1"></i> {{ __('Make Request') }}
                                </a>
                                <a href="{{ url('storeDashboard') }}" class="btn btn-default btn-sm text-bold" title="Back">
                                    <i class="fa fa-arrow-left text-muted mr-1"></i> {{ __('common.Back') }}
                                </a>
                            </div>
                        </div>  
                        
                        <div class="card-body border-bottom p-2">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-12 mb-2 mb-md-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                        </div>
                                        <input type="text" id="tableSearch" class="form-control" placeholder="Search item name or configurations...">
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 mb-2 mb-md-0">
                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                        <button class="btn btn-white border active filter-btn" data-filter="all">All Items</button>
                                        <button class="btn btn-white border filter-btn text-danger" data-filter="low">Low Stock</button>
                                        <button class="btn btn-white border filter-btn text-warning" data-filter="reserved">Reserved</button>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 text-md-right text-left">
                                    <button id="addRow" class="btn btn-xs btn-primary px-3 text-bold"><i class="fa fa-plus-circle mr-1"></i> Add Item</button>
                                    <button id="editRow" class="btn btn-xs btn-warning px-3 text-bold text-white"><i class="fa fa-edit mr-1"></i> Edit Selected</button>
                                    <button id="saveRow" class="btn btn-xs btn-success px-3 text-bold" disabled><i class="fa fa-save mr-1"></i> Save Changes</button>
                                    <button id="deleteSelected" class="btn btn-xs btn-danger px-3 text-bold"><i class="fa fa-trash mr-1"></i> Delete Selected</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0" style="max-height: 600px;">
                            <table class="table table-head-fixed table-hover text-nowrap table-bordered" id="stockTable">
                                <thead>
                                    <tr class="bg-light">
                                        <th style="width: 40px; text-align: center; vertical-align: middle;" class="no-sort">
                                            <input type="checkbox" id="selectAll" class="custom-checkbox pointer">
                                        </th>
                                        <th class="sortable-header pointer" data-column-index="1">Name Item <span class="sort-icon text-muted small ml-1"><i class="fa fa-sort"></i></span></th>
                                        <th class="sortable-header pointer" data-column-index="2">Rate <span class="sort-icon text-muted small ml-1"><i class="fa fa-sort"></i></span></th>
                                        <th class="sortable-header pointer" data-column-index="3">Available Qty <span class="sort-icon text-muted small ml-1"><i class="fa fa-sort"></i></span></th>
                                        <th class="sortable-header pointer" data-column-index="4" style="min-width: 240px;">Stock Level Status <span class="sort-icon text-muted small ml-1"><i class="fa fa-sort"></i></span></th>
                                        <th class="sortable-header pointer" data-column-index="5">Sale Qty Status Ledger <span class="sort-icon text-muted small ml-1"><i class="fa fa-sort"></i></span></th>
                                        <th class="sortable-header pointer text-right pr-4" data-column-index="6">Calculated Revenue <span class="sort-icon text-muted small ml-1"><i class="fa fa-sort"></i></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($data) && count($data) > 0)
                                        @php $i = 1; @endphp
                                        @foreach($data as $key => $item)
                                        @php
                                            $available_qty = $item->qty - $item->reserved_qty - $item->sold_qty;
                                            $lowLimit = $item->low_stock_limit ?? 50;
                                            $isLowStock = ($available_qty <= $lowLimit);
                                            $hasSales = (($item->sold_qty ?? 0) > 0);
                                            
                                            $maxCapacity = ($item->qty > 0) ? $item->qty : 100;
                                            $percentage = max(0, min(100, ($available_qty / $maxCapacity) * 100));
                                            
                                            $formattedPercent = ($percentage == 100) ? '100%' : number_format($percentage, 2) . '%';
                                        @endphp
                                        <tr data-new="false" 
                                            data-id="{{ $item->id ?? '' }}" 
                                            data-item_name="{{ $item->name ?? '' }}" 
                                            data-reserved="{{ $item->reserved_qty ?? 0 }}" 
                                            data-sold-qty="{{ $item->sold_qty ?? 0 }}"
                                            data-lowstock="{{ $isLowStock ? 'true' : 'false' }}"
                                            data-total-qty="{{ $item->qty ?? 100 }}"
                                            data-low-limit="{{ $lowLimit }}"
                                            data-raw-rate="{{ $item->rate ?? 0 }}"
                                            class="{{ $isLowStock ? 'low-stock-row' : '' }} {{ $hasSales ? 'immutable-invoice-row' : '' }}">
                                            
                                            <td class="text-center" style="vertical-align: middle;">
                                                <input type="checkbox" class="row-checkbox custom-checkbox pointer">
                                                <span class="text-muted ml-2 small font-weight-bold row-index-num">{{ $i++ }}</span>
                                            </td>
                                            <td class="font-weight-bold text-secondary" style="vertical-align: middle;">
                                                <span class="item-name-text">{{ $item->name ?? '' }}</span>
                                                @if($hasSales)
                                                    <span class="badge badge-pill badge-success-soft ml-1" title="Item has generated sales vouchers." data-toggle="tooltip">
                                                        <i class="fa fa-shield"></i> Ledger Active
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-dark font-weight-bold target-rate-cell" style="vertical-align: middle;">₹ {{ number_format($item->rate ?? 0, 2) }}</td>
                                            
                                            <td style="vertical-align: middle;" data-raw-qty="{{ $available_qty }}" class="qty-numerical-cell">
                                                <span class="font-weight-bold {{ $isLowStock ? 'text-danger' : 'text-dark' }} style-qty-label">
                                                    {{ $available_qty }}
                                                </span>
                                            </td>

                                            <td style="vertical-align: middle;" class="stock-progress-matrix" data-raw-pct="{{ $percentage }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 mr-3">
                                                        <div class="progress progress-xs bg-dark-accent rounded-pill" style="height: 6px; background-color: #e9ecef;">
                                                            <div class="progress-bar rounded-pill {{ $isLowStock ? 'bg-danger-gradient' : 'bg-success-gradient' }}" 
                                                                 role="progressbar" 
                                                                 style="width: {{ $percentage }}%;" 
                                                                 aria-valuenow="{{ $percentage }}" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="text-xs text-muted tracking-wide mt-1 d-block font-weight-600 pct-label-string">
                                                            {{ $formattedPercent }} available
                                                        </span>
                                                    </div>
                                                    @if($isLowStock)
                                                        <div class="low-stock-pill-capsule">
                                                            <i class="fa fa-bolt mr-1"></i> Low
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <td style="vertical-align: middle;" data-raw-sold="{{ $item->sold_qty ?? 0 }}">
                                                <button class="btn btn-light border btn-sm showSoldOutItems font-weight-bold shadow-xs mr-1" type="button">
                                                    <i class="fa fa-shopping-cart text-success mr-1"></i> Sold out <span class="badge badge-dark ml-1">{{ $item->sold_qty ?? 0 }}</span>
                                                </button>
                                                @if(($item->reserved_qty ?? 0) > 0)       
                                                    <button class="btn btn-light border btn-sm text-warning font-weight-bold shadow-xs" type="button">
                                                        <i class="fa fa-bookmark text-warning mr-1"></i> Reserved <span class="badge badge-warning text-white ml-1">{{ $item->reserved_qty }}</span>
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="text-right pr-4 font-weight-bold text-success" style="vertical-align: middle;" data-raw-rev="{{ ($item->rate ?? 0) * ($item->sold_qty ?? 0) }}">
                                                ₹ {{ number_format(($item->rate ?? 0) * ($item->sold_qty ?? 0), 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr id="emptyRowPlaceholder">
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fa fa-folder-open-o fa-2x mb-2 d-block"></i> No university inventory rows found items registered.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<div class="modal fade" id="soldOutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="fa fa-list-alt mr-2"></i> Sold Items Breakdown Engine</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body scrollable p-4" style="max-height: 550px; overflow-y: auto; background-color: #fafafa;">
                <div class="d-flex align-items-center justify-content-center py-4 text-muted processing-loader">
                    <i class="fa fa-circle-o-notch fa-spin fa-2x mr-2"></i> Querying Database ledger records...
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-secondary text-bold" data-bs-dismiss="modal">Dismiss View</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-bold"><i class="fa fa-exclamation-triangle mr-1"></i> Direct Deletion Safe Lock</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="h6 text-secondary mb-0">Are you absolutely sure you want to drop selected configuration data parameters? This action cannot be reverted.</p>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-default text-bold px-3" data-bs-dismiss="modal">Abort</button>
                <button type="button" class="btn btn-danger text-bold px-4 shadow-xs" id="delete_btn">Confirm Execution</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    
    if($.fn.tooltip) { $('[data-toggle="tooltip"]').tooltip(); }

    let activeSegmentFilter = 'all';
    let currentSortColumn = null;
    let currentSortOrder = 'asc';

    // Core Consolidated Filter Processor
    function applyCombinedFilters() {
        let textSearchValue = $("#tableSearch").val().toLowerCase().trim();

        $("#stockTable tbody tr").not('#emptyRowPlaceholder').each(function() {
            let row = $(this);
            if(row.attr('data-new') === 'true') return; 
            
            let matchesSegment = false;
            if (activeSegmentFilter === 'all') {
                matchesSegment = true;
            } else if (activeSegmentFilter === 'low') {
                matchesSegment = (row.attr('data-lowstock') === 'true');
            } else if (activeSegmentFilter === 'reserved') {
                let resVal = parseInt(row.attr('data-reserved')) || 0;
                matchesSegment = (resVal > 0);
            }

            let matchesSearch = false;
            let rowTextContent = row.text().toLowerCase();
            if (textSearchValue === "" || rowTextContent.indexOf(textSearchValue) > -1) {
                matchesSearch = true;
            }

            if (matchesSegment && matchesSearch) {
                row.show();
            } else {
                row.hide();
            }
        });
    }

    // CLIENT SIDE MULTI-DATATYPE SORT ENGINE LAYER
    $('.sortable-header').on('click', function() {
        let th = $(this);
        let colIndex = parseInt(th.data('column-index'));
        let tbody = $('#stockTable tbody');
        
        let rowsArray = tbody.find('tr').not('#emptyRowPlaceholder').not('[data-new="true"]').get();
        let virtualAddedRows = tbody.find('tr[data-new="true"]').get();

        if (currentSortColumn === colIndex) {
            currentSortOrder = (currentSortOrder === 'asc') ? 'desc' : 'asc';
        } else {
            currentSortColumn = colIndex;
            currentSortOrder = 'asc';
        }

        $('.sortable-header').find('.sort-icon').html('<i class="fa fa-sort"></i>').addClass('text-muted').removeClass('text-primary');
        th.find('.sort-icon').html(currentSortOrder === 'asc' ? '<i class="fa fa-sort-amount-asc"></i> ▲' : '<i class="fa fa-sort-amount-desc"></i> ▼').removeClass('text-muted').addClass('text-primary');

        rowsArray.sort(function(a, b) {
            let valA, valB;

            switch(colIndex) {
                case 1: // Name Item sorting
                    valA = $(a).find('.item-name-text').text().trim().toLowerCase();
                    valB = $(b).find('.item-name-text').text().trim().toLowerCase();
                    return currentSortOrder === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                
                case 2: // FIXED: Reads data attributes natively to completely ignore typography formatting components
                    valA = parseFloat($(a).attr('data-raw-rate')) || 0;
                    valB = parseFloat($(b).attr('data-raw-rate')) || 0;
                    break;
                
                case 3: // Available Qty sorting
                    valA = parseInt($(a).find('.qty-numerical-cell').text().trim()) || 0;
                    valB = parseInt($(b).find('.qty-numerical-cell').text().trim()) || 0;
                    break;
                
                case 4: // Stock Level Percent sorting
                    valA = parseFloat($(a).find('.stock-progress-matrix').attr('data-raw-pct')) || 0;
                    valB = parseFloat($(b).find('.stock-progress-matrix').attr('data-raw-pct')) || 0;
                    break;
                
                case 5: // Sold Qty sorting
                    valA = parseInt($(a).attr('data-sold-qty')) || 0;
                    valB = parseInt($(b).attr('data-sold-qty')) || 0;
                    break;
                
                case 6: // Revenue volume sorting
                    valA = parseFloat($(a).find('td:eq(6)').attr('data-raw-rev')) || 0;
                    valB = parseFloat($(b).find('td:eq(6)').attr('data-raw-rev')) || 0;
                    break;
                
                default:
                    return 0;
            }

            if (valA < valB) return currentSortOrder === 'asc' ? -1 : 1;
            if (valA > valB) return currentSortOrder === 'asc' ? 1 : -1;
            return 0;
        });

        tbody.empty();
        if(virtualAddedRows.length > 0) { tbody.append(virtualAddedRows); }
        $.each(rowsArray, function(index, sortedRow) {
            tbody.append(sortedRow);
        });

        let indexCounter = 1;
        tbody.find('tr').not('#emptyRowPlaceholder').each(function() {
            $(this).find('.row-index-num').text(indexCounter++);
        });
    });

    $("#tableSearch").on("keyup", function() {
        applyCombinedFilters();
    });

    $('.filter-btn').on('click', function(e) {
        e.preventDefault();
        $('.filter-btn').removeClass('btn-primary text-white').addClass('btn-white border');
        $(this).addClass('btn-primary text-white').removeClass('btn-white border');
        
        activeSegmentFilter = $(this).data('filter');
        applyCombinedFilters();
    });

    // Process & Render Compact System Alert Banners [Referencing image_c15c3a.png]
    function updateSystemAlertBanners() {
        let lowStockNames = [];
        let reservedDetails = [];
        let lowStockCount = 0;
        let reservedUnits = 0;

        $('#stockTable tbody tr').not('#emptyRowPlaceholder').each(function() {
            let row = $(this);
            let itemName = row.attr('data-item_name') || row.find('.item-name-text').text().trim();
            
            if (row.attr('data-lowstock') === 'true') {
                lowStockCount++;
                if(itemName) lowStockNames.push(itemName);
            }
            
            let resQty = parseInt(row.attr('data-reserved')) || 0;
            if (resQty > 0) {
                reservedUnits += resQty;
                if(itemName) reservedDetails.push(`${itemName} (${resQty})`);
            }
        });

        $('#lowStockMetricCount').text(lowStockCount);
        $('#reservedMetricCount').text(reservedUnits);

        if (lowStockNames.length > 0) {
            $('#lowStockItemsList').text(lowStockNames.join(', '));
            $('#lowStockBanner').removeClass('d-none');
        } else {
            $('#lowStockBanner').addClass('d-none');
        }

        if (reservedDetails.length > 0) {
            $('#reservedItemsList').text(reservedDetails.join(', '));
            $('#reservedStockBanner').removeClass('d-none');
        } else {
            $('#reservedStockBanner').addClass('d-none');
        }
    }
    
    updateSystemAlertBanners();

    // Trigger Hold Release Execution Logic
    $('#triggerReleaseBtn').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'question',
            title: 'Stale Active Reservations Found',
            text: 'System detected active student stationery reservations pending collection. Release all holds older than 30 business minutes intervals safely?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Release Stocks Lock',
            cancelButtonText: 'Cancel Action',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d'
        }).then(res => {
            if(!res.isConfirmed) return;
            $.get('/releaseStaleStoreReservations', function(backendResponse){
                backendResponse.status ? toastr.success(backendResponse.message) : toastr.error(backendResponse.message);
                if(backendResponse.status) setTimeout(() => location.reload(), 1000);
            });
        });
    });

    // Open Drawer Breakdown Ledger Records Event Drawer
    $(document).on('click', '.showSoldOutItems', function (e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var itemId = row.data('id');
        var item_name = row.data('item_name');

        $('#soldOutModal .modal-body').html('<div class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin fa-2x mr-2"></i>Fetching item parameters matrix ledger...</div>');
        $('#soldOutModal').modal('show');

        $.ajax({
            url: "{{ url('showSoldOutItems') }}",
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                item_id: itemId
            },
            success: function (response) {
                if (response.status) {
                    var summary = response.summary;
                    var rows = '';

                    $.each(response.data, function (i, item) {
                        rows += `<tr>
                            <td class="text-center font-weight-bold text-muted">${i + 1}</td>
                            <td><span class="badge badge-secondary px-2">${item.admission_id}</span></td>
                            <td class="text-bold text-dark">${item.first_name}</td>
                            <td class="text-center font-weight-bold text-primary">${item.qty}</td>
                            <td class="text-success font-weight-bold">₹${parseFloat(item.price).toFixed(2)}</td>
                            <td><i class="fa fa-calendar mr-1 text-muted"></i>${item.date.split('-').reverse().join('-')}</td>
                            <td><span class="text-monospace text-xs text-bold">${item.receipt_no}</span></td>
                        </tr>`;
                    });

                    var html = `
                        <div class="card card-body shadow-sm border-0 mb-3" style="background: linear-gradient(135deg, #28a745, #1e7e34); color:#fff;">
                            <div class="row text-center text-md-left">
                                <div class="col-md-3 mb-2 mb-md-0 border-right-md border-white-50">
                                    <small class="d-block text-white-50 text-uppercase tracking-wider">Target Item Ledger</small>
                                    <h4 class="font-weight-bold mb-0 text-warning">${item_name}</h4>
                                </div>
                                <div class="col-md-3 mb-2 mb-md-0 border-right-md border-white-50">
                                    <small class="d-block text-white-50 text-uppercase tracking-wider">Unique Students Buyers</small>
                                    <h4 class="font-weight-bold mb-0">${summary.total_students}</h4>
                                </div>
                                <div class="col-md-3 mb-2 mb-md-0 border-right-md border-white-50">
                                    <small class="d-block text-white-50 text-uppercase tracking-wider">Aggregated Qty Dispatched</small>
                                    <h4 class="font-weight-bold mb-0">${summary.total_qty_sold} Units</h4>
                                </div>
                                <div class="col-md-3">
                                    <small class="d-block text-white-50 text-uppercase tracking-wider">Aggregated Liquid Value</small>
                                    <h4 class="font-weight-bold mb-0">₹${parseFloat(summary.total_revenue).toLocaleString('en-IN', {minimumFractionDigits: 2})}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <h6 class="text-uppercase text-muted font-weight-bold mb-0"><i class="fa fa-user-circle mr-1 text-secondary"></i> Student Transaction Logs</h6>
                            <button class="btn btn-success btn-sm shadow-sm" id="exportExcelBtn">
                                <i class="fa fa-file-excel-o mr-1"></i> Export Complex Spreadsheet Document
                            </button>
                        </div>

                        <div class="table-responsive bg-white rounded shadow-sm border">
                            <table class="table table-sm table-hover mb-0" id="soldOutTable">
                                <thead class="thead-dark text-xs text-uppercase">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Admission ID</th>
                                        <th>Student Name</th>
                                        <th class="text-center">Qty</th>
                                        <th>Settled Price</th>
                                        <th>Date Logged</th>
                                        <th>Receipt Reference</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        </div>`;

                    $('#soldOutModal .modal-body').html(html);

                    $('#exportExcelBtn').data('summary', summary);
                    $('#exportExcelBtn').data('itemname', item_name);
                    $('#exportExcelBtn').data('excelrows', response.data);
                } else {
                    $('#soldOutModal .modal-body').html('<div class="alert alert-warning"><i class="fa fa-info-circle mr-1"></i>No historical record verified for selection item.</div>');
                }
            },
            error: function () {
                $('#soldOutModal .modal-body').html('<div class="alert alert-danger"><i class="fa fa-warning mr-1"></i>Internal transactional query error framework execution fault.</div>');
            }
        });
    });

    // Excel Exporter Engine Processors
    $(document).on('click', '#exportExcelBtn', function () {
        var summary  = $(this).data('summary');
        var itemName = $(this).data('itemname');
        var data     = $(this).data('excelrows');

        var titleS  = { font:{bold:true,color:{rgb:'FFFFFF'},sz:13,name:'Calibri'}, fill:{fgColor:{rgb:'1a7a3c'}}, alignment:{horizontal:'left',vertical:'center',wrapText:true} };
        var headerS = { font:{bold:true,color:{rgb:'FFFFFF'},sz:12,name:'Calibri'}, fill:{fgColor:{rgb:'1f2d40'}}, alignment:{horizontal:'center',vertical:'center'}, border:{top:{style:'medium',color:{rgb:'000000'}},bottom:{style:'medium',color:{rgb:'000000'}},left:{style:'thin',color:{rgb:'333333'}},right:{style:'thin',color:{rgb:'333333'}}} };
        var evenS   = { font:{sz:11,name:'Calibri'}, fill:{fgColor:{rgb:'EAF4FB'}}, alignment:{horizontal:'center',vertical:'center'}, border:{top:{style:'thin',color:{rgb:'B8D0E0'}},bottom:{style:'thin',color:{rgb:'B8D0E0'}},left:{style:'thin',color:{rgb:'B8D0E0'}},right:{style:'thin',color:{rgb:'B8D0E0'}}} };
        var oddS    = { font:{sz:11,name:'Calibri'}, fill:{fgColor:{rgb:'FFFFFF'}}, alignment:{horizontal:'center',vertical:'center'}, border:{top:{style:'thin',color:{rgb:'B8D0E0'}},bottom:{style:'thin',color:{rgb:'B8D0E0'}},left:{style:'thin',color:{rgb:'B8D0E0'}},right:{style:'thin',color:{rgb:'B8D0E0'}}} };
        var nameES  = { ...evenS, alignment:{horizontal:'left',vertical:'center'} };
        var nameOS  = { ...oddS,  alignment:{horizontal:'left',vertical:'center'} };
        var footLS  = { font:{bold:true,color:{rgb:'333333'},sz:12,name:'Calibri'}, fill:{fgColor:{rgb:'D6EAD8'}}, alignment:{horizontal:'left',vertical:'center'}, border:{top:{style:'medium',color:{rgb:'1a7a3c'}},bottom:{style:'medium',color:{rgb:'1a7a3c'}},left:{style:'medium',color:{rgb:'1a7a3c'}},right:{style:'thin',color:{rgb:'b0b0b0'}}} };
        var footS   = { font:{bold:true,color:{rgb:'1a7a3c'},sz:12,name:'Calibri'}, fill:{fgColor:{rgb:'D6EAD8'}}, alignment:{horizontal:'right',vertical:'center'}, border:{top:{style:'medium',color:{rgb:'1a7a3c'}},bottom:{style:'medium',color:{rgb:'1a7a3c'}},left:{style:'thin',color:{rgb:'b0b0b0'}},right:{style:'thin',color:{rgb:'b0b0b0'}}} };
        var footES  = { font:{sz:11}, fill:{fgColor:{rgb:'D6EAD8'}}, border:{top:{style:'medium',color:{rgb:'1a7a3c'}},bottom:{style:'medium',color:{rgb:'1a7a3c'}},left:{style:'thin',color:{rgb:'b0b0b0'}},right:{style:'medium',color:{rgb:'1a7a3c'}}} };
        var emptyS  = { font:{sz:11}, fill:{fgColor:{rgb:'FAFAFA'}}, border:{top:{style:'thin',color:{rgb:'E8E8E8'}},bottom:{style:'thin',color:{rgb:'E8E8E8'}},left:{style:'thin',color:{rgb:'E8E8E8'}},right:{style:'thin',color:{rgb:'E8E8E8'}}} };
        var spacerS = { fill:{fgColor:{rgb:'FFFFFF'}} };
        
        var wsData = [
            [{ v:`Item: ${itemName}  |  Total Students: ${summary.total_students}  |  Total Qty Sold: ${summary.total_qty_sold}  |  Total Revenue: Rs. ${summary.total_revenue}`, s:titleS }],
            [{ v:'', s:spacerS }],
            [{v:'#',s:headerS},{v:'Admission ID',s:headerS},{v:'Student Name',s:headerS},{v:'Qty',s:headerS},{v:'Price',s:headerS},{v:'Date',s:headerS},{v:'Receipt No',s:headerS}]
        ];

        $.each(data, function (i, item) {
            var rs = i%2===0 ? evenS : oddS;
            var ns = i%2===0 ? nameES : nameOS;
            wsData.push([
                {v:i+1,                                       s:rs},
                {v:item.admission_id,                         s:rs},
                {v:item.first_name,                           s:ns},
                {v:item.qty,                                  s:rs},
                {v:'Rs. '+item.price,                         s:rs},
                {v:item.date.split('-').reverse().join('-'),  s:rs},
                {v:item.receipt_no,                           s:rs},
            ]);
        });

        wsData.push([{v:'',s:spacerS}]);
        wsData.push([
            {v:'Total Summary',              s:footLS},
            {v:'',s:footS},{v:'',s:footS},
            {v:summary.total_qty_sold,       s:footS},
            {v:'Rs. '+summary.total_revenue, s:footS},
            {v:'',s:footES},{v:'',s:footES},
        ]);

        for (var e=0; e<40; e++) wsData.push(Array(7).fill({v:'',s:emptyS}));

        var ws = XLSX.utils.aoa_to_sheet(wsData);
        ws['!cols']   = [{wch:5},{wch:14},{wch:26},{wch:7},{wch:13},{wch:13},{wch:12}];
        ws['!merges'] = [{s:{r:0,c:0}, e:{r:0,c:6}}, {s:{r:1,c:0}, e:{r:1,c:6}}];
        ws['!rows']   = [{hpt:28}, {hpt:6}, {hpt:22}];

        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sold Items');
        XLSX.writeFile(wb, 'Sold_Item_'+ itemName.replace(/\s+/g,'_') +'.xlsx');
    });

    // Dynamic Row Generation Added to TOP of table body with sorting attribute hook injected
    $('#addRow').on('click', function(e) {
        e.preventDefault();
        $('#emptyRowPlaceholder').remove();
        $('#saveRow').prop('disabled', false);
        
        const newRow = `<tr data-new="true" data-lowstock="false" data-total-qty="0" data-sold-qty="0" data-low-limit="50" data-raw-rate="0">
            <td class="text-center" style="vertical-align: middle;">
                <input type="checkbox" checked class="row-checkbox custom-checkbox">
            </td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Enter Name"></td>
            <td data-raw-rate="0"><input type="tel" class="form-control form-control-sm text-bold" placeholder="Rate" onkeypress="return isNumber(event)"></td>
            <td><input type="text" class="form-control form-control-sm text-bold" placeholder="Initial Qty" onkeypress="return isNumberOrMinus(event)"></td>
            <td style="vertical-align: middle;" class="stock-progress-matrix" data-raw-pct="0">
                <span class="text-muted small italic">Calculated upon save</span>
            </td>
            <td style="vertical-align: middle;"><span class="text-muted small italic">Awaiting sync</span></td>
            <td class="text-right pr-4 font-weight-bold text-muted" style="vertical-align: middle;" data-raw-rev="0">₹ 0.00</td>
        </tr>`;
        
        $('#stockTable tbody').prepend(newRow); 
    });

    // Checkbox Controller Mechanism Global Toggle 
    $('#selectAll').on('click', function() {
        var state = $(this).is(':checked');
        $('table tbody').find('input.row-checkbox').prop('checked', state);
    });

    // Edit Selected Structural Inline Engine Mode Toggler
    $('#editRow').on('click', function(e) {
        e.preventDefault();
        const checkedRows = $('table tbody').find('input.row-checkbox:checked');
        if (checkedRows.length === 0) {
            toastr.error('Please select at least one item record row to alter configurations.');
            return;
        }
        
        $('#saveRow').prop('disabled', false);

        checkedRows.each(function() {
            const row = $(this).closest('tr');
            if(row.attr('data-new') === 'true') return;

            const nameCell = row.children().eq(1);
            const rateCell = row.children().eq(2);
            const qtyCell = row.children().eq(3);
            
            let soldQty = parseInt(row.attr('data-sold-qty')) || 0;

            if (!nameCell.has('input').length) {
                const nameText = row.attr('data-item_name') || nameCell.find('.item-name-text').text().trim();
                const rateText = row.attr('data-raw-rate') || rateCell.text().replace('₹', '').replace(/,/g, '').trim();
                const qtyText = qtyCell.attr('data-raw-qty') || qtyCell.text().trim();

                nameCell.html(`<input type="text" class="form-control form-control-sm" value="${nameText}">`);
                rateCell.html(`<input type="tel" class="form-control form-control-sm text-bold" value="${rateText}" onkeypress="return isNumber(event)">`);
                
                if (soldQty > 0) {
                    qtyCell.html(`<input type="text" class="form-control form-control-sm border-warning text-bold bg-warning-light add-stock-input" placeholder="+/- Adj Stock" onkeypress="return isNumberOrMinus(event)">`);
                } else {
                    qtyCell.html(`<input type="text" class="form-control form-control-sm text-bold normal-qty-input" value="${qtyText}" onkeypress="return isNumberOrMinus(event)">`);
                }
            }
        });

        $('#deleteSelected').prop('disabled', true);
    });

    // Save Changes Matrix Logic Engine
    $('#saveRow').on('click', function(e) {
        e.preventDefault();
        const checkedRows = $('table tbody').find('input.row-checkbox:checked');
        if (checkedRows.length === 0) {
            toastr.error('Please select targets row data package context to persist variables.');
            return;
        }

        let totalToProcess = checkedRows.length;
        let processedSuccessCount = 0;

        checkedRows.each(function() {
            const row = $(this).closest('tr');
            const isNew = row.attr('data-new') === 'true';
            const id = row.attr('data-id');
            let soldQty = parseInt(row.attr('data-sold-qty')) || 0;
            let lowLimit = parseInt(row.attr('data-low-limit')) || 50;
            
            const name = row.find('td:eq(1) input').length ? row.find('td:eq(1) input').val() : row.attr('data-item_name');
            const rate = row.find('td:eq(2) input').length ? row.find('td:eq(2) input').val() : row.attr('data-raw-rate');
            
            let postedQtyToSend = 0;
            
            if (isNew) {
                postedQtyToSend = parseInt(row.find('td:eq(3) input').val()) || 0;
            } else {
                let addStockInput = row.find('.add-stock-input');
                let normalQtyInput = row.find('.normal-qty-input');
                
                if (addStockInput.length) {
                    let stockBatchAddition = parseInt(addStockInput.val()) || 0;
                    let baselineTotalStock = parseInt(row.attr('data-total-qty')) || 0;
                    postedQtyToSend = baselineTotalStock + stockBatchAddition;
                } else if (normalQtyInput.length) {
                    postedQtyToSend = parseInt(normalQtyInput.val()) || 0;
                } else {
                    postedQtyToSend = parseInt(row.attr('data-total-qty')) || 0;
                }
            }

            if(postedQtyToSend < soldQty) {
                toastr.error('Process Aborted: Total pool stock cannot be adjusted below current aggregate sales ledger records (' + soldQty + ' units sold).');
                return;
            }

            if(name !== "" && rate !== "" && name !== undefined) {
                $.ajax({
                    url: 'addStoreItem',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: isNew ? null : id,
                        name: name,
                        rate: rate,
                        qty: postedQtyToSend 
                    },
                    success: function(response) {
                        processedSuccessCount++;
                        
                        let updatedTotalQty = postedQtyToSend;
                        let updatedAvailableQty = updatedTotalQty - (parseInt(row.attr('data-reserved')) || 0) - soldQty;
                        let currentRevenue = parseFloat(rate) * soldQty;

                        row.removeAttr('data-new');
                        row.attr('data-id', response.id);
                        row.attr('data-item_name', name);
                        row.attr('data-raw-rate', rate);
                        row.attr('data-raw-qty', updatedAvailableQty);
                        row.attr('data-total-qty', updatedTotalQty);
                        
                        // FIXED: Re-bind operational configuration parameters directly onto row attributes during execution
                        row.attr('data-raw-rate', rate);
                        row.find('td:eq(2)').attr('data-raw-rate', rate);
                        row.find('td:eq(6)').attr('data-raw-rev', currentRevenue);

                        let appendSoldTag = soldQty > 0 ? ' <span class="badge badge-pill badge-success-soft ml-1"><i class="fa fa-shield"></i> Ledger Active</span>' : '';
                        row.find('td:eq(1)').html(`<span class="item-name-text">${name}</span>` + appendSoldTag).addClass('font-weight-bold text-secondary');
                        row.find('td:eq(2)').html('₹ ' + parseFloat(rate).toFixed(2)).addClass('font-weight-bold');
                        
                        let isLow = (updatedAvailableQty <= lowLimit);
                        row.attr('data-lowstock', isLow ? 'true' : 'false');
                        row.find('td:eq(3)').html(`<span class="font-weight-bold ${isLow ? 'text-danger' : 'text-dark'}">${updatedAvailableQty}</span>`);
                        
                        let maxCapacity = (updatedTotalQty > 0) ? updatedTotalQty : 100;
                        let pctValue = Math.max(0, Math.min(100, (updatedAvailableQty / maxCapacity) * 100));
                        
                        let formattedPct = (pctValue === 100) ? '100%' : pctValue.toFixed(2) + '%';
                        let progressLabel = isLow ? formattedPct + ' critical limit' : formattedPct + ' available';
                        
                        row.find('.stock-progress-matrix').attr('data-raw-pct', pctValue);
                        let progressHtml = `
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 mr-3">
                                    <div class="progress progress-xs rounded-pill" style="height: 6px; background-color: #e9ecef;">
                                        <div class="progress-bar rounded-pill ${isLow ? 'bg-danger-gradient' : 'bg-success-gradient'}" style="width: ${pctValue}%;"></div>
                                    </div>
                                    <span class="text-xs text-muted tracking-wide mt-1 d-block font-weight-600">${progressLabel}</span>
                                </div>
                                ${isLow ? '<div class="low-stock-pill-capsule"><i class="fa fa-bolt mr-1"></i> Low</div>' : ''}
                            </div>`;
                        
                        row.find('.stock-progress-matrix').html(progressHtml);
                        row.find('td:eq(6)').html('₹ ' + currentRevenue.toLocaleString('en-IN', {minimumFractionDigits: 2}));

                        if(isLow) {
                            row.addClass('low-stock-row');
                        } else {
                            row.removeClass('low-stock-row');
                        }
                        
                        row.find('input.row-checkbox').prop('checked', false);

                        if(processedSuccessCount === totalToProcess) {
                            toastr.success('All matching parameter rows saved successfully.');
                            updateSystemAlertBanners();
                            applyCombinedFilters(); 
                        }
                    },
                    error: function() {
                        toastr.error('Error occurred executing operational row persistence context.');
                    }
                });
            } else {
                toastr.error('Validation failure. All fields require active formatting parameters.');
            }
        });

        $('#selectAll').prop('checked', false);
        $('#deleteSelected').prop('disabled', false);
    });

    // Delete Operations Target Trigger Framework Handler with Invoice Safe Guard Checks
    $('#deleteSelected').on('click', function(e) {
        e.preventDefault();
        const checkedRows = $('table tbody').find('input.row-checkbox:checked');
        
        if (checkedRows.length === 0) {
            toastr.error('Please mark target selection rows items to trigger drop execution pipeline.');
            return;
        }

        let immutableDetected = false;
        checkedRows.each(function(){
            let row = $(this).closest('tr');
            let soldQty = parseInt(row.attr('data-sold-qty')) || 0;
            if (soldQty > 0) { immutableDetected = true; }
        });

        if (immutableDetected) {
            Swal.fire({
                icon: 'error',
                title: 'Action Prohibited',
                text: 'One or more selected store items contain active sales invoices or historical transactions. Deletion is restricted to secure financial ledger audit compliance.',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        $('#deleteModal').modal('show');
    });
    
    $('#delete_btn').click(function(e) {
        e.preventDefault();
        const checkedRows = $('table tbody').find('input.row-checkbox:checked');
        
        checkedRows.each(function() {
            const row = $(this).closest('tr');
            const isNew = row.attr('data-new') === 'true';
            const id = row.attr('data-id');
            const soldQty = parseInt(row.attr('data-sold-qty')) || 0;
            
            if(soldQty > 0) return; 

            if(isNew) {
                toastr.success('Virtual Row dynamic asset removed.');
                row.remove();
            } else {
                $.ajax({
                    url: 'deleteStoreItem',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id
                    },
                    success: function() {
                        toastr.success('Database verified index asset persistent row dropped.');
                        row.remove();
                        updateSystemAlertBanners();
                    },
                    error: function() {
                        toastr.error('An exception error framework response denied deletion process parameters.');
                    }
                });
            }
        }); 

        $('#deleteModal').modal('hide');
        $('#selectAll').prop('checked', false);
    });

});

// Numeric baseline validation
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// Allows negative dash formatting bounds
function isNumberOrMinus(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 45) {
        return true;
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>

<style>
    /* High Density Embedded Notice Banners Styles [Image Reference Rules matching image_c15c3a.png] */
    .alert-custom-danger {
        background-color: #fff2f3 !important;
        border: 1px solid #fccacf !important;
        color: #b21f2d !important;
        border-radius: 6px;
        padding: 10px 16px;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }
    .alert-custom-danger .alert-icon {
        color: #dc3545;
        font-size: 1.1rem;
    }
    .alert-custom-warning {
        background-color: #fff9e6 !important;
        border: 1px solid #ffeaa8 !important;
        color: #856404 !important;
        border-radius: 6px;
        padding: 10px 16px;
        font-size: 0.95rem;
        margin-bottom: 16px;
    }
    .alert-custom-warning .alert-icon {
        color: #ffc107;
        font-size: 1.1rem;
    }
    .card-title{
        font-size: 17px !important;
        font-weight: 600 !important
    }
    /* Ultra Space Saving Compact Metrics Box Styling [Image Reference Rules matching image_c15b84.png] */
    .compact-metric-box {
        padding: 10px 14px !important;
        margin-bottom: 0px !important;
        border-radius: 6px !important;
        overflow: hidden;
        position: relative;
    }
    .compact-metric-box .inner {
        padding: 2px 0 !important;
    }
    .compact-metric-box .metric-num {
        font-size: 1.15rem !important;
        font-weight: 800 !important;
        margin: 0 0 2px 0 !important;
        white-space: nowrap;
    }
    .compact-metric-box .metric-lbl {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        margin: 0 !important;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    .compact-metric-box .icon-compact {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2.2rem;
        opacity: 0.16;
        transition: all 0.3s linear;
        pointer-events: none;
    }
    .compact-metric-box:hover .icon-compact {
        transform: translateY(-50%) scale(1.1);
        opacity: 0.25;
    }

    /* System Protection Soft Pill Elements styling */
    .badge-success-soft {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.15);
        font-weight: 600;
        padding: 3px 8px;
    }
    .bg-warning-light {
        background-color: #fffdf5 !important;
    }

    /* Base Grid System Overrides */
    .scrollable::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .scrollable::-webkit-scrollbar-thumb {
        background-color: #ced4da;
        border-radius: 4px;
    }
    .scrollable::-webkit-scrollbar-thumb:hover {
        background-color: #adb5bd;
    }
    .low-stock-row {
        background-color: #fff8f8 !important;
    }
    .low-stock-row:hover {
        background-color: #ffeef0 !important;
    }
    .low-stock-row .style-qty-label {
        color: #dc3545 !important;
    }
    .pointer {
        cursor: pointer;
    }
    .tracking-wider {
        letter-spacing: 0.06em;
    }
    @media (min-width: 768px) {
        .border-right-md {
            border-right: 1px solid rgba(255,255,255,0.2) !important;
        }
    }
    .custom-checkbox {
        transform: scale(1.15);
        accent-color: #007bff;
    }
    .table-head-fixed th {
        position: sticky;
        top: 0;
        background-color: #f4f6f9 !important;
        z-index: 10;
        border-bottom: 2px solid #dee2e6 !important;
        box-shadow: inset 0 -1px 0 #dee2e6;
        user-select: none;
    }
    .btn-white {
        background-color: #ffffff;
        color: #495057;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
        color: #212529;
    }
    .bg-success-gradient {
        background: linear-gradient(90deg, #28a745, #34ce57) !important;
    }
    .bg-danger-gradient {
        background: linear-gradient(90deg, #dc3545, #ff4d5e) !important;
    }
    .font-weight-600 {
        font-weight: 600;
    }
    .low-stock-pill-capsule {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 2px 10px;
        border-radius: 50px;
        border: 1px solid rgba(220, 53, 69, 0.2);
        display: inline-flex;
        align-items: center;
    }
    .sort-icon .text-primary {
        font-weight: bold;
    }
</style>
@endsection