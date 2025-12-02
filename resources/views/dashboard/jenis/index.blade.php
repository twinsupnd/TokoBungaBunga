@extends('dashboard.layout')

@section('title', 'Kelola Produk')

@section('content')

    <style>
        .section {
            margin-bottom: 32px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
            align-items: start;
            margin-bottom: 28px;
            box-sizing: border-box;
            font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 6px 18px rgba(86, 63, 163, 0.06);
            border: 1px solid #efeafc;
            max-width: none;
            margin: 0;
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 12px 32px rgba(86, 63, 163, 0.08);
        }

        .card h2 {
            margin: 0 0 12px 0;
            font-size: 16px;
            font-weight: 600;
            color: #3b2f61;
            text-align: left;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #5b497f;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .form-input {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            /* penting */
            padding: 12px 14px;
            /* sedikit dikecilkan */
            border: 1px solid #ede8f8;
            border-radius: 10px;
            font-size: 14px;
            background: linear-gradient(180deg, #ffffff, #fbf8ff);
            color: #2f2a4a;
            transition: all 0.14s ease;
            box-shadow: 0 2px 8px rgba(99, 72, 171, 0.04);
        }

        .form-input::placeholder {
            color: #bdb3d6;
        }

        .form-input:focus {
            outline: none;
            border-color: #a78bfa;
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.1);
            background: #fff;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-size: 15px;
            box-shadow: 0 4px 14px rgba(167, 139, 250, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #a78bfa, #fbc2eb);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(167, 139, 250, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #f9f7ff;
            color: #8b7aad;
            border: 1.5px solid #d4c9e8;
        }

        .btn-secondary:hover {
            background: #f3f0fa;
            border-color: #a78bfa;
            color: #7b6b9d;
        }

        .btn-secondary:active {
            transform: scale(0.98);
        }

        .table-wrapper {
            overflow-x: auto;
            margin-top: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
            font-size: 14px;
        }

        thead th {
            background: #faf8ff;
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            color: #4b3c7a;
            font-size: 13px;
            border-bottom: 2px solid #f0eaf9;
        }

        tbody td {
            padding: 12px 10px;
            border-bottom: 1px solid #f7f5fd;
            color: #2f2a4a;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr {
            transition: background 0.12s ease;
        }

        tbody tr:hover {
            background: #faf8ff;
        }

        .action-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .table-actions {
            display: flex;
            justify-content: flex-end;
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.14s ease;
            white-space: nowrap;
            border: none;
        }

        .action-pill {
            padding: 7px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            border: none;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .link-view {
            color: #6b46c1;
            background: #f5f1ff;
            border: 1px solid #e9e3f8;
        }

        .link-view:hover {
            background: #ede8f8;
            border-color: #d4c9e8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(107, 70, 193, 0.08);
        }

        .link-edit {
            color: #7b3b6f;
            background: #fff6fb;
            border: 1px solid #f3d9ed;
        }

        .link-edit:hover {
            background: #fff0f7;
            border-color: #e9c5e0;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(123, 59, 111, 0.08);
        }

        .link-delete {
            color: #d63a3a;
            background: #fff8f8;
            border: 1px solid #fae5e5;
        }

        .link-delete:hover {
            background: #fff0f0;
            border-color: #f8d4d4;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(214, 58, 58, 0.08);
        }

        .inline-form {
            display: inline;
        }

        .empty-state {
            text-align: center;
            padding: 28px 16px;
            color: #8a8a9b;
        }

        .thumb {
            width: 96px;
            height: 96px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #f0eaf9;
            box-shadow: 0 2px 8px rgba(89, 63, 133, 0.06);
            transition: all 0.2s ease;
        }

        tbody tr:hover .thumb {
            box-shadow: 0 4px 12px rgba(89, 63, 133, 0.12);
            transform: scale(1.02);
        }

        .name-cell {
            font-weight: 600;
            color: #2f2a4a;
        }

        .price-cell {
            color: #7c5ba3;
            font-weight: 600;
        }

        .count-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
        }

        .in-stock {
            background: #f3fdf3;
            color: #2e7d32;
        }

        .out-stock {
            background: #fff0f0;
            color: #c62828;
        }

        @media (max-width: 900px) {
            .product-grid {
                display: block;
            }

            .card {
                padding: 14px 10px;
            }

            thead th,
            tbody td {
                font-size: 13px;
                padding: 8px 6px;
            }
        }
    </style>
    @if (session('success'))
        <div id="admin-alert"
            style="max-width:1200px;margin:12px auto;padding:12px 18px;background:#ecfdf5;border:1px solid #bbf7d0;color:#064e3b;border-radius:10px;font-weight:600;">
            {{ session('success') }}</div>
    @else
        <div id="admin-alert"
            style="display:none;max-width:1200px;margin:12px auto;padding:12px 18px;border-radius:10px;font-weight:600;">
        </div>
    @endif
    <div class="product-grid">
        <!-- Top: Form (Tambah Produk) -->
        <div class="card">
            <h2>Tambah Produk</h2>
            <form id="create-form" action="{{ route('dashboard.jenis.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    <input type="text" name="name" id="name" class="form-input"
                        placeholder="Contoh: Bunga Mawar Merah" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" name="price" id="price" class="form-input" placeholder="Contoh: 75000"
                        min="0" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" name="stock" id="stock" class="form-input" placeholder="Contoh: 50"
                        min="0">
                </div>
                <div class="form-group">
                    <label for="image">Gambar Produk (opsional)</label>
                    <div class="file-input-wrap" style="display:flex;gap:10px;align-items:center;">
                        <label for="image" class="btn btn-secondary"
                            style="padding:10px 14px; border-radius:10px; font-weight:600; cursor:pointer;">Pilih
                            Gambar</label>
                        <span id="file-name" style="color:#8b83a6;font-size:13px;">Tidak ada file dipilih</span>
                    </div>
                    <input type="file" name="image" id="image" accept="image/*" class="form-input"
                        style="display:none;">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi singkat</label>
                    <textarea name="description" id="description" class="form-input" rows="3"
                        placeholder="Opsional, deskripsi singkat..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                    style="width:100%; background: linear-gradient(90deg,#a78bfa,#fbc2eb); color:#fff;">Simpan</button>
            </form>
        </div>

        <!-- Bottom: Table -->
        <div class="card">
            <h2 id="product-count-heading">Daftar Produk ({{ $items->count() }})</h2>
            @if ($items->count())
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="padding:8px 6px; font-size:13px; font-weight:500;">Gambar</th>
                                <th style="padding:8px 6px; font-size:13px; font-weight:500;">Nama Produk</th>
                                <th style="padding:8px 6px; font-size:13px; font-weight:500;">Harga</th>
                                <th style="padding:8px 6px; font-size:13px; font-weight:500;">Stok</th>
                                <th style="padding:8px 6px; font-size:13px; font-weight:500;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr style="font-size:14px;">
                                    <td style="text-align:center; width:120px;">
                                        @if ($item->image)
                                            <img src="{{ asset($item->image) }}?v={{ strtotime($item->updated_at) }}"
                                                alt="{{ $item->name }}" class="thumb">
                                        @else
                                            <img src="{{ asset('images/babybreath.jpg') }}" alt="{{ $item->name }}"
                                                class="thumb">
                                        @endif
                                    </td>
                                    <td class="name-cell">{{ $item->name }}</td>
                                    <td class="price-cell">Rp {{ number_format((float) $item->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($item->stock > 0)
                                            <span
                                                style="background:#f3fdf3; color:#2ecc40; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">{{ $item->stock }}
                                                unit</span>
                                        @else
                                            <span
                                                style="background:#fff0f0; color:#ff3b3b; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">Stok
                                                Habis</span>
                                        @endif
                                    </td>
                                    <td style="padding:6px;">
                                        <div class="action-cell" style="gap:6px;">
                                            <button type="button" class="action-link action-pill link-edit js-edit-btn"
                                                title="Edit Produk" data-slug="{{ $item->slug }}"
                                                data-route="{{ route('dashboard.jenis.update', $item->slug) }}"
                                                data-name="{{ $item->name }}" data-price="{{ $item->price }}"
                                                data-stock="{{ $item->stock }}"
                                                data-description="{{ $item->description ?? '' }}"
                                                data-image="{{ $item->image ? asset($item->image) : asset('images/babybreath.jpg') }}">Edit</button>
                                            <form action="{{ route('dashboard.jenis.destroy', $item->slug) }}"
                                                method="POST" class="inline-form"
                                                onsubmit="return confirm('Yakin hapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-link action-pill link-delete"
                                                    title="Hapus Produk">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div style="font-size:18px; font-weight:600; margin-bottom:6px;">Belum ada produk</div>
                    <div style="color:#9b9bb0;">Tambahkan produk melalui formulir di sebelah kiri.</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal"
        style="display:none; position:fixed; inset:0; z-index:1200; align-items:center; justify-content:center;">
        <div id="edit-overlay" style="position:absolute; inset:0; background:rgba(0,0,0,0.45);"></div>
        <div
            style="position:relative; width:560px; max-width:96%; background:#fff; border-radius:12px; padding:18px; box-shadow:0 24px 64px rgba(16,24,40,0.35); z-index:1201;">
            <h3 style="margin:0 0 8px;">Edit Produk</h3>
            <div id="edit-errors" style="color:#b91c1c;margin-bottom:8px;display:none;"></div>
            <form id="edit-form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit-name">Nama Produk</label>
                    <input type="text" name="name" id="edit-name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="edit-price">Harga (Rp)</label>
                    <input type="number" name="price" id="edit-price" class="form-input" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit-stock">Stok</label>
                    <input type="number" name="stock" id="edit-stock" class="form-input" min="0">
                </div>
                <div class="form-group">
                    <label>Gambar Saat Ini</label>
                    <div style="display:flex;gap:12px;align-items:center;margin-bottom:8px;">
                        <img id="edit-image-preview" src="" alt="preview"
                            style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #f0eaf9;">
                        <div style="flex:1">
                            <div style="margin-bottom:6px;font-size:13px;color:#6b6b80;">Ganti gambar (opsional)</div>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <label for="edit-image" class="btn btn-secondary"
                                    style="padding:8px 12px;border-radius:8px;cursor:pointer;">Pilih Gambar</label>
                                <span id="edit-file-name" style="color:#8b83a6;font-size:13px;">Tidak ada file
                                    dipilih</span>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="image" id="edit-image" accept="image/*" style="display:none;">
                </div>
                <div class="form-group">
                    <label for="edit-description">Deskripsi singkat</label>
                    <textarea name="description" id="edit-description" class="form-input" rows="3"></textarea>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
                    <button type="button" id="edit-cancel" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            // Add form (left) file input filename display
            var input = document.getElementById('image');
            var nameEl = document.getElementById('file-name');
            if (input) {
                input.addEventListener('change', function(e) {
                    var name = (e.target.files && e.target.files.length) ? e.target.files[0].name :
                        'Tidak ada file dipilih';
                    if (nameEl) nameEl.textContent = name;
                });
            }

            // Templates for building new row URLs
            var urlTemplates = {
                update: "{{ url('dashboard/jenis') }}/:slug",
                destroy: "{{ url('dashboard/jenis') }}/:slug"
            };

            // Edit modal logic with AJAX submit
            var modal = document.getElementById('edit-modal');
            var overlay = document.getElementById('edit-overlay');
            var editForm = document.getElementById('edit-form');
            // We'll use event delegation so newly-inserted rows also work
            var editName = document.getElementById('edit-name');
            var editPrice = document.getElementById('edit-price');
            var editStock = document.getElementById('edit-stock');
            var editDescription = document.getElementById('edit-description');
            var editImage = document.getElementById('edit-image');
            var editPreview = document.getElementById('edit-image-preview');
            var editFileName = document.getElementById('edit-file-name');
            var editCancel = document.getElementById('edit-cancel');
            var editErrors = document.getElementById('edit-errors');
            var adminAlert = document.getElementById('admin-alert');

            var currentEditButton = null;
            var currentSlug = null;

            function openModal() {
                modal.style.display = 'flex';
                modal.style.alignItems = 'center';
                modal.style.justifyContent = 'center';
                if (editErrors) {
                    editErrors.style.display = 'none';
                    editErrors.innerHTML = '';
                }
            }

            function closeModal() {
                modal.style.display = 'none';
                // reset file input display
                if (editImage) {
                    editImage.value = null;
                    editFileName.textContent = 'Tidak ada file dipilih';
                }
            }

            function showAdminAlert(message, ok) {
                if (!adminAlert) return;
                adminAlert.style.display = 'block';
                adminAlert.style.background = ok ? '#ecfdf5' : '#fff1f2';
                adminAlert.style.border = ok ? '1px solid #bbf7d0' : '1px solid #fca5a5';
                adminAlert.style.color = ok ? '#064e3b' : '#b91c1c';
                adminAlert.textContent = message;
                setTimeout(function() {
                    adminAlert.style.display = ok ? 'block' : 'block';
                }, 5000);
            }

            function updateProductCount() {
                var countHeading = document.getElementById('product-count-heading');
                if (countHeading) {
                    var tbody = document.querySelector('table tbody');
                    var count = tbody ? tbody.querySelectorAll('tr').length : 0;
                    countHeading.textContent = 'Daftar Produk (' + count + ')';
                }
            }

            document.addEventListener('click', function(e) {
                var b = e.target.closest && e.target.closest('.js-edit-btn');
                if (!b) return;
                e.preventDefault();
                currentEditButton = b;
                currentSlug = b.getAttribute('data-slug');
                var route = b.getAttribute('data-route') || urlTemplates.update.replace(':slug', currentSlug);
                var name = b.getAttribute('data-name') || '';
                var price = b.getAttribute('data-price') || '';
                var stock = b.getAttribute('data-stock') || '';
                var description = b.getAttribute('data-description') || '';
                var image = b.getAttribute('data-image') || '';

                if (editForm) {
                    editForm.action = route;
                    // store the original slug so we can match the row if server changes slug
                    editForm.dataset.originalSlug = currentSlug;
                }
                if (editName) editName.value = name;
                if (editPrice) editPrice.value = price;
                if (editStock) editStock.value = stock;
                if (editDescription) editDescription.value = description;
                if (editPreview) editPreview.src = image;
                if (editFileName) editFileName.textContent = 'Tidak ada file dipilih';

                openModal();
            });

            if (overlay) overlay.addEventListener('click', closeModal);
            if (editCancel) editCancel.addEventListener('click', closeModal);

            if (editImage) {
                editImage.addEventListener('change', function(e) {
                    var file = (e.target.files && e.target.files[0]) ? e.target.files[0] : null;
                    if (file) {
                        editFileName.textContent = file.name;
                        var reader = new FileReader();
                        reader.onload = function(evt) {
                            if (editPreview) editPreview.src = evt.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        editFileName.textContent = 'Tidak ada file dipilih';
                    }
                });
            }

            // AJAX submit for create form
            var createForm = document.getElementById('create-form');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var fd = new FormData(createForm);
                    fetch(createForm.action, {
                        method: 'POST',
                        body: fd,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(function(res) {
                        if (res.status === 422) return res.json().then(function(json) {
                            throw {
                                status: 422,
                                errors: json.errors
                            };
                        });
                        return res.json().catch(function() {
                            return null;
                        });
                    }).then(function(data) {
                        if (!data) {
                            location.reload();
                            return;
                        }
                        if (data.success && data.item) {
                            var item = data.item;
                            // build row HTML
                            var tbody = document.querySelector('table tbody');
                            if (!tbody) return;
                            var tr = document.createElement('tr');
                            tr.style.fontSize = '14px';
                            tr.innerHTML = '' +
                                '<td style="text-align:center; width:120px;">' +
                                (item.image_url ? '<img src="' + item.image_url + '?v=' + item
                                    .updated_at + '" alt="' + (item.name || '') + '" class="thumb">' :
                                    '<img src="{{ asset('images/babybreath.jpg') }}" class="thumb">') +
                                '</td>' +
                                '<td class="name-cell">' + (item.name || '') + '</td>' +
                                '<td class="price-cell">Rp ' + (item.price ? Number(item.price)
                                    .toLocaleString('id-ID') : '0') + '</td>' +
                                '<td>' + (item.stock > 0 ?
                                    '<span style="background:#f3fdf3; color:#2ecc40; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">' +
                                    item.stock + ' unit</span>' :
                                    '<span style="background:#fff0f0; color:#ff3b3b; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">Stok Habis</span>'
                                    ) + '</td>' +
                                '<td style="padding:6px;">' +
                                '<div class="action-cell" style="gap:6px;">' +
                                '<button type="button" class="action-link action-pill link-edit js-edit-btn" title="Edit Produk" data-slug="' +
                                item.slug + '" data-route="' + urlTemplates.update.replace(':slug', item
                                    .slug) + '" data-name="' + (item.name || '') + '" data-price="' + (
                                    item.price || '') + '" data-stock="' + (item.stock || '') +
                                '" data-description="' + (item.description || '') + '" data-image="' + (
                                    item.image_url ? item.image_url + '?v=' + item.updated_at : '') +
                                '">Edit</button>' +
                                '<form action="' + urlTemplates.destroy.replace(':slug', item.slug) +
                                '" method="POST" class="inline-form" onsubmit="return confirm(\'Yakin hapus produk ini?\');">' +
                                '@csrf'.replace(/@csrf/g, '{{ csrf_field() }}') +
                                '<input type="hidden" name="_method" value="DELETE">' +
                                '<button type="submit" class="action-link action-pill link-delete" title="Hapus Produk" onclick="setTimeout(function(){ updateProductCount(); }, 100);">Hapus</button>' +
                                '</form>' +
                                '</div>' +
                                '</td>';

                            // insert at top of tbody
                            if (tbody.firstChild) tbody.insertBefore(tr, tbody.firstChild);
                            else tbody.appendChild(tr);

                            // reset create form
                            createForm.reset();
                            var fileNameEl = document.getElementById('file-name');
                            if (fileNameEl) fileNameEl.textContent = 'Tidak ada file dipilih';

                            updateProductCount();
                            showAdminAlert('Produk baru ditambahkan.', true);
                        }
                    }).catch(function(err) {
                        if (err && err.status === 422 && err.errors) {
                            var messages = [];
                            Object.keys(err.errors).forEach(function(k) {
                                err.errors[k].forEach(function(m) {
                                    messages.push(m);
                                });
                            });
                            showAdminAlert(messages.join(' \n '), false);
                        } else {
                            showAdminAlert('Gagal menambahkan produk.', false);
                        }
                        console.error('Create submit error', err);
                    });
                });
            }

            // AJAX submit handler
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!editForm.action) return;
                    var fd = new FormData(editForm);
                    // ensure method override exists (form has hidden _method input from @method('PUT'))

                    fetch(editForm.action, {
                        method: 'POST',
                        body: fd,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(function(res) {
                        if (res.status === 422) return res.json().then(function(json) {
                            throw {
                                status: 422,
                                errors: json.errors
                            };
                        });
                        return res.json().catch(function() {
                            return null;
                        });
                    }).then(function(data) {
                        if (!data) {
                            // If no JSON returned, fall back to full reload
                            location.reload();
                            return;
                        }
                        if (data.success && data.item) {
                            var item = data.item;
                            // update table row
                            var btn = document.querySelector('.js-edit-btn[data-slug="' + item.slug + '"]');
                            // if we can't find by the new slug, fall back to the original slug saved on the form
                            if (!btn && editForm && editForm.dataset && editForm.dataset.originalSlug) {
                                btn = document.querySelector('.js-edit-btn[data-slug="' + editForm.dataset.originalSlug + '"]');
                            }
                            if (btn) {
                                var row = btn.closest('tr');
                                if (row) {
                                    var nameCell = row.querySelector('.name-cell');
                                    if (nameCell) nameCell.textContent = item.name;
                                    var priceCell = row.querySelector('.price-cell');
                                    if (priceCell) priceCell.textContent = 'Rp ' + (item.price ? Number(
                                        item.price).toLocaleString('id-ID') : '0');
                                    var stockCell = row.querySelector('td:nth-child(4)');
                                    if (stockCell) {
                                        if (item.stock > 0) {
                                            stockCell.innerHTML =
                                                '<span style="background:#f3fdf3; color:#2ecc40; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">' +
                                                item.stock + ' unit</span>';
                                        } else {
                                            stockCell.innerHTML =
                                                '<span style="background:#fff0f0; color:#ff3b3b; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">Stok Habis</span>';
                                        }
                                    }
                                    var img = row.querySelector('img.thumb');
                                    if (img) {
                                        if (item.image_url) img.src = item.image_url + '?v=' + item
                                            .updated_at;
                                    }

                                    // update button data attributes for future edits
                                    btn.setAttribute('data-name', item.name || '');
                                    btn.setAttribute('data-price', item.price || '');
                                    btn.setAttribute('data-stock', item.stock || '');
                                    btn.setAttribute('data-description', item.description || '');
                                    btn.setAttribute('data-image', item.image_url ? item.image_url + '?v=' + item.updated_at : '');
                                    // if slug changed on the server, update the button's data-slug so future edits target the correct resource
                                    if (item.slug && btn.getAttribute('data-slug') !== item.slug) {
                                        btn.setAttribute('data-slug', item.slug);
                                    }
                                }
                            }

                            showAdminAlert('Perubahan tersimpan.', true);
                            // optionally close modal shortly after success
                            setTimeout(function() {
                                closeModal();
                            }, 700);
                        } else {
                            showAdminAlert('Perubahan selesai.', true);
                            setTimeout(function() {
                                closeModal();
                            }, 700);
                        }
                    }).catch(function(err) {
                        if (err && err.status === 422 && err.errors) {
                            if (editErrors) {
                                editErrors.style.display = 'block';
                                editErrors.innerHTML = '';
                                Object.keys(err.errors).forEach(function(k) {
                                    err.errors[k].forEach(function(m) {
                                        var d = document.createElement('div');
                                        d.textContent = m;
                                        editErrors.appendChild(d);
                                    });
                                });
                            }
                        } else {
                            showAdminAlert('Terjadi kesalahan. Coba lagi.', false);
                        }
                        console.error('Edit submit error', err);
                    });
                });
            }
        })();
    </script>

@endsection
