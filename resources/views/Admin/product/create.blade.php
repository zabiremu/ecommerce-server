@extends('Admin.Layout.app')

@section('title', 'Add New Product')
@section('page_title', 'Add New Product')

@push('styles')
<style>
    .wc-tab-btn { padding: 10px 16px; font-size: 13px; font-weight: 500; color: #50575e; border-left: 4px solid transparent; background: #f6f7f7; text-align: left; transition: all .15s; display: block; width: 100%; }
    .wc-tab-btn:hover { background: #fff; color: #1d2327; }
    .wc-tab-btn.active { background: #fff; color: #2271b1; border-left-color: #2271b1; font-weight: 600; }
    .wc-tab-btn i { width: 20px; margin-right: 6px; color: #787c82; }
    .wc-tab-btn.active i { color: #2271b1; }
    .wc-tab-panel { display: none; padding: 18px 20px; }
    .wc-tab-panel.active { display: block; }
    .wc-field { display: grid; grid-template-columns: 180px 1fr; gap: 12px; align-items: center; padding: 8px 0; }
    .wc-field > label { font-size: 13px; color: #1d2327; font-weight: 500; }
    .wc-field > label .req { color: #d63638; }
    .wc-input { padding: 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; width: 100%; max-width: 360px; }
    .wc-input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    textarea.wc-input { max-width: none; min-height: 80px; resize: vertical; }
    .wc-input-full { max-width: none !important; }
    .wc-panel { background: #fff; border: 1px solid #c3c4c7; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
    .wc-panel-h { padding: 8px 12px; font-size: 14px; font-weight: 600; color: #1d2327; border-bottom: 1px solid #c3c4c7; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: space-between; }
    .wc-panel-body { padding: 12px; }
    .wc-title-input { width: 100%; padding: 6px 8px; font-size: 1.7em; line-height: 1.4; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; }
    .wc-title-input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .wc-permalink { font-size: 13px; color: #50575e; padding: 4px 0; }
    .wc-permalink input { padding: 2px 6px; font-size: 12px; border: 1px solid #c3c4c7; border-radius: 3px; min-width: 200px; }
    .wc-submit-bar { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: #fff; border: 1px solid #c3c4c7; }
    .wc-btn { padding: 6px 14px; font-size: 13px; font-weight: 500; border-radius: 3px; cursor: pointer; border: 1px solid; transition: all .15s; }
    .wc-btn-primary { background: #2271b1; border-color: #2271b1; color: #fff; }
    .wc-btn-primary:hover { background: #135e96; border-color: #135e96; }
    .wc-btn-secondary { background: #f6f7f7; border-color: #2271b1; color: #2271b1; }
    .wc-btn-secondary:hover { background: #f0f0f1; }
    .wc-btn-link { background: transparent; border-color: transparent; color: #2271b1; }
    .wc-btn-link:hover { color: #135e96; text-decoration: underline; }
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }
    .wc-radio-row label { display: inline-flex; align-items: center; gap: 6px; margin-right: 16px; font-size: 13px; color: #1d2327; cursor: pointer; }
    .img-upload-box-wc { border: 1px dashed #c3c4c7; background: #fff; border-radius: 4px; position: relative; overflow: hidden; cursor: pointer; transition: border-color .15s; }
    .img-upload-box-wc:hover { border-color: #2271b1; }
    .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; }
    .small-help { font-size: 12px; color: #646970; margin-top: 4px; }
</style>
@endpush

@section('content')

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-12 lg:col-span-8 space-y-5">
            <div>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Add title"
                       class="wc-title-input">
                <div class="wc-permalink mt-2">
                    <span>Slug: </span>
                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generate">
                </div>
            </div>

            <div class="wc-panel">
                <div class="wc-panel-h">Product short description</div>
                <div class="wc-panel-body">
                    <textarea name="short_description" rows="3" maxlength="500" class="wc-input wc-input-full" placeholder="Brief summary shown on listings (max 500 chars)">{{ old('short_description') }}</textarea>
                </div>
            </div>

            <div class="wc-panel">
                <div class="wc-panel-h">Product description</div>
                <div class="wc-panel-body">
                    <textarea name="long_description" rows="8" class="wc-input wc-input-full" placeholder="Detailed product description">{{ old('long_description') }}</textarea>
                </div>
            </div>

            <div class="wc-panel">
                <div class="wc-panel-h">Product data
                    <select id="productTypeSelect" onchange="toggleType(this.value)" class="wc-input" style="max-width: 180px; padding: 4px 8px;">
                        <option value="physical" {{ old('type', 'physical') === 'physical' ? 'selected' : '' }}>Simple product</option>
                        <option value="digital" {{ old('type') === 'digital' ? 'selected' : '' }}>Digital / Downloadable</option>
                    </select>
                </div>
                <input type="hidden" name="type" id="typeHidden" value="{{ old('type', 'physical') }}">
                <div class="grid grid-cols-12 min-h-[280px]">
                    <div class="col-span-12 sm:col-span-3 border-r border-[#c3c4c7] bg-[#f6f7f7]">
                        <button type="button" class="wc-tab-btn active" data-tab="general"><i class="fas fa-wrench"></i> General</button>
                        <button type="button" class="wc-tab-btn" data-tab="inventory"><i class="fas fa-cubes"></i> Inventory</button>
                        <button type="button" class="wc-tab-btn" data-tab="variants"><i class="fas fa-list"></i> Variants</button>
                        <button type="button" class="wc-tab-btn" data-tab="advanced"><i class="fas fa-cog"></i> Advanced</button>
                    </div>
                    <div class="col-span-12 sm:col-span-9">
                        <div class="wc-tab-panel active" data-panel="general">
                            <div class="wc-field">
                                <label>Regular price <span class="req">*</span></label>
                                <input type="number" step="0.01" min="0" name="selling_price" value="{{ old('selling_price', 0) }}" required class="wc-input">
                            </div>
                            <div class="wc-field">
                                <label>Sale price</label>
                                <input type="number" step="0.01" min="0" name="sale_price" value="{{ old('sale_price') }}" class="wc-input" placeholder="Optional — must be less than regular price">
                            </div>
                            <div class="wc-field">
                                <label>Purchase price <span class="req">*</span></label>
                                <input type="number" step="0.01" min="0" name="purchase_price" value="{{ old('purchase_price', 0) }}" required class="wc-input">
                            </div>
                            <div id="digitalFields" class="wc-field" style="display:none">
                                <label>Downloadable file</label>
                                <div class="flex-1">
                                    <input type="file" name="digital_file" class="wc-input">
                                    <p class="small-help">Allowed: zip, pdf, mp3, mp4, avi, jpg, png (max 100MB)</p>
                                </div>
                            </div>
                        </div>

                        <div class="wc-tab-panel" data-panel="inventory">
                            <div class="wc-field">
                                <label>SKU <span class="req">*</span></label>
                                <input type="text" name="sku" value="{{ old('sku') }}" required class="wc-input" placeholder="e.g. NF-PROD-001">
                            </div>
                            <div class="wc-field">
                                <label>Barcode</label>
                                <input type="text" name="barcode" value="{{ old('barcode') }}" class="wc-input" placeholder="Leave empty to use SKU">
                            </div>
                            <div id="physicalFields">
                                <div class="wc-field">
                                    <label>Low stock threshold</label>
                                    <input type="number" step="0.01" min="0" name="alert_quantity" value="{{ old('alert_quantity') }}" class="wc-input" placeholder="e.g. 10">
                                    <p class="text-[12px] text-[#646970] mt-1">Show "Low stock" warning when stock falls to this number.</p>
                                </div>
                                <div class="px-3 py-2 bg-[#f0f6fc] border-l-4 border-[#2271b1] text-[12.5px] text-[#1d2327]">
                                    <i class="fas fa-info-circle mr-1 text-[#2271b1]"></i>
                                    Stock is updated automatically when a <strong>Goods Received Note (GRN)</strong> is created against a purchase. New products start with 0 stock.
                                </div>
                            </div>
                        </div>

                        <div class="wc-tab-panel" data-panel="variants">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-[13px] text-[#50575e]">Add product attribute combinations (size, color, etc.)</p>
                                <button type="button" onclick="addVariant()" class="wc-btn wc-btn-secondary"><i class="fas fa-plus mr-1"></i> Add Variant</button>
                            </div>
                            <div class="px-3 py-2 mb-3 bg-[#f0f6fc] border-l-4 border-[#2271b1] text-[12.5px] text-[#1d2327]">
                                <i class="fas fa-info-circle mr-1 text-[#2271b1]"></i>
                                New products start with 0 stock. Variant stock totals will be validated against available stock once the product receives stock via GRN (edit the product after stock arrives).
                            </div>
                            <div id="variantsContainer" class="space-y-2"></div>
                            <template id="variantTemplate">
                                <div class="variant-row border border-[#c3c4c7] rounded p-3 bg-[#fafafa]">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                        <input type="text" name="variants[INDEX][name]" placeholder="Name (e.g. Red Large)" class="wc-input wc-input-full">
                                        <input type="text" name="variants[INDEX][size]" placeholder="Size" class="wc-input wc-input-full">
                                        <input type="text" name="variants[INDEX][color]" placeholder="Color" class="wc-input wc-input-full">
                                        <input type="number" step="0.01" name="variants[INDEX][price]" placeholder="Price" class="wc-input wc-input-full">
                                        <input type="number" step="0.01" name="variants[INDEX][stock]" placeholder="Stock" class="wc-input wc-input-full">
                                        <input type="text" name="variants[INDEX][sku]" placeholder="SKU" class="wc-input wc-input-full">
                                    </div>
                                    <div class="text-right mt-2">
                                        <button type="button" onclick="$(this).closest('.variant-row').remove()" class="wc-btn-link text-red-600 text-[12px]"><i class="fas fa-trash"></i> Remove</button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="wc-tab-panel" data-panel="advanced">
                            <div class="wc-field">
                                <label>Brand</label>
                                <select name="brand_id" class="wc-input">
                                    <option value="">— Select —</option>
                                    @foreach ($brands as $b)
                                        <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="wc-field">
                                <label>Unit</label>
                                <select name="unit_id" class="wc-input">
                                    <option value="">— Select —</option>
                                    @foreach ($units as $u)
                                        <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="wc-field">
                                <label>Supplier</label>
                                <select name="supplier_id" class="wc-input">
                                    <option value="">— Select —</option>
                                    @foreach ($suppliers as $s)
                                        <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="wc-field" style="align-items: start">
                                <label>Internal note</label>
                                <textarea name="description" rows="3" class="wc-input wc-input-full" placeholder="Internal description / note">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 space-y-5">
            <div class="wc-panel">
                <div class="wc-panel-h">Publish</div>
                <div class="wc-panel-body space-y-3">
                    <div class="flex items-center gap-2 text-[13px] text-[#1d2327]">
                        <i class="fas fa-thumbtack text-[#787c82]"></i>
                        <strong>Status:</strong>
                        <select name="publish_status" class="wc-input" style="max-width: 180px; padding: 2px 6px; font-size: 12.5px;">
                            <option value="draft" {{ old('publish_status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="pending" {{ old('publish_status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="published" {{ old('publish_status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <hr class="border-[#dcdcde]">
                    <div class="flex items-center justify-between">
                        <button type="submit" name="publish_status" value="draft" class="wc-btn wc-btn-secondary">Save Draft</button>
                        <button type="submit" name="publish_status" value="published" class="wc-btn wc-btn-primary">Publish</button>
                    </div>
                </div>
            </div>

            <div class="wc-panel">
                <div class="wc-panel-h">Product categories</div>
                <div class="wc-panel-body">
                    <select name="category_id" required class="wc-input wc-input-full">
                        <option value="">— Select category —</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="wc-panel">
                <div class="wc-panel-h">Product image</div>
                <div class="wc-panel-body">
                    <label for="thumbnailInput" class="img-upload-box-wc img-upload-box block w-full aspect-square">
                        <div class="img-placeholder text-center px-3 absolute inset-0 flex flex-col items-center justify-center">
                            <i class="fas fa-cloud-arrow-up text-3xl text-[#787c82]"></i>
                            <p class="text-[12px] text-[#50575e] mt-2 font-medium">Set product image</p>
                            <p class="text-[11px] text-[#787c82] mt-1">JPG, PNG, WebP · 300×300</p>
                        </div>
                        <img class="img-preview absolute inset-0 w-full h-full object-cover" alt="" style="display:none;">
                        <input id="thumbnailInput" type="file" name="thumbnail" accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;">
                    </label>
                    <button type="button" class="img-remove wc-btn-link text-[12px] mt-2" style="display:none;"><i class="fas fa-xmark mr-1"></i> Remove image</button>
                </div>
            </div>

            <div class="wc-panel">
                <div class="wc-panel-h">
                    Product gallery
                    <button type="button" onclick="addGalleryItem()" class="wc-btn-link text-[12px]"><i class="fas fa-plus mr-1"></i> Add</button>
                </div>
                <div class="wc-panel-body">
                    <div id="galleryContainer" class="gallery-grid"></div>
                    <p class="small-help mt-2">Click a tile to upload. 800×800 max. With optional color label.</p>

                    <template id="galleryTemplate">
                        <div class="gallery-row relative">
                            <label class="img-upload-box img-upload-box-wc block w-full aspect-square">
                                <div class="img-placeholder text-center absolute inset-0 flex flex-col items-center justify-center">
                                    <i class="fas fa-image text-xl text-[#787c82]"></i>
                                    <p class="text-[10.5px] text-[#50575e] mt-1">Upload</p>
                                </div>
                                <img class="img-preview absolute inset-0 w-full h-full object-cover" alt="" style="display:none;">
                                <input type="file" name="gallery_items[INDEX][file]" accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;">
                            </label>
                            <button type="button" onclick="removeGalleryItem(this)"
                                    class="gallery-remove absolute top-1 right-1 w-5 h-5 rounded-full bg-red-500 hover:bg-red-600 text-white grid place-items-center text-[9px] shadow z-10" style="display:none;">
                                <i class="fas fa-xmark"></i>
                            </button>
                            <input type="text" name="gallery_items[INDEX][color]" placeholder="Color"
                                   class="wc-input wc-input-full mt-1" style="padding: 3px 6px; font-size: 11px;">
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="wc-submit-bar mt-5">
        <a href="{{ route('admin.products.index') }}" class="wc-btn wc-btn-link">← Back to products</a>
        <div class="flex items-center gap-2">
            <button type="submit" name="publish_status" value="draft" class="wc-btn wc-btn-secondary">Save Draft</button>
            <button type="submit" name="publish_status" value="pending" class="wc-btn wc-btn-secondary" style="border-color:#dba617;color:#dba617;">Submit for Review</button>
            <button type="submit" name="publish_status" value="published" class="wc-btn wc-btn-primary">Publish</button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    var galleryIndex = 0;
    var variantIndex = 0;

    $(function () {
        $('.wc-tab-btn').on('click', function () {
            var tab = $(this).data('tab');
            $('.wc-tab-btn').removeClass('active');
            $(this).addClass('active');
            $('.wc-tab-panel').removeClass('active');
            $('.wc-tab-panel[data-panel="' + tab + '"]').addClass('active');
        });

        addGalleryItem();
        bindImagePreview(document);
        toggleType($('#productTypeSelect').val());

        $('#name').on('blur', function () {
            var slug = $(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            var $slug = $('input[name="slug"]');
            if (!$slug.val()) $slug.val(slug);
        });
    });

    function toggleType(type) {
        $('#typeHidden').val(type);
        if (type === 'digital') {
            $('#physicalFields').hide();
            $('#digitalFields').css('display', 'grid');
        } else {
            $('#physicalFields').show();
            $('#digitalFields').hide();
        }
    }

    function bindImagePreview(scope) {
        $(scope).find('.img-upload-box input[type="file"]').off('change.preview').on('change.preview', function () {
            var $box = $(this).closest('.img-upload-box');
            var $row = $(this).closest('.gallery-row');
            var $img = $box.find('.img-preview');
            var $placeholder = $box.find('.img-placeholder');
            var $remove = $row.find('.gallery-remove').add($box.closest('.wc-panel-body').find('.img-remove'));
            var file = this.files && this.files[0];
            if (!file) {
                $img.hide().attr('src', '');
                $placeholder.show();
                $remove.hide();
                return;
            }
            var reader = new FileReader();
            reader.onload = function (e) {
                $img.attr('src', e.target.result).show();
                $placeholder.hide();
                $remove.show();
            };
            reader.readAsDataURL(file);
        });
    }

    function addGalleryItem() {
        var tmpl = document.getElementById('galleryTemplate').innerHTML;
        var html = tmpl.replace(/INDEX/g, galleryIndex);
        var $row = $(html);
        $('#galleryContainer').append($row);
        bindImagePreview($row);
        galleryIndex++;
    }

    function removeGalleryItem(btn) {
        $(btn).closest('.gallery-row').remove();
    }

    function addVariant() {
        var tmpl = document.getElementById('variantTemplate').innerHTML;
        var html = tmpl.replace(/INDEX/g, variantIndex);
        $('#variantsContainer').append(html);
        variantIndex++;
    }

    $(document).on('click', '.img-remove', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $box = $(this).closest('.wc-panel-body').find('.img-upload-box');
        $box.find('input[type="file"]').val('');
        $box.find('.img-preview').hide().attr('src', '');
        $box.find('.img-placeholder').show();
        $(this).hide();
    });
</script>
@endpush
