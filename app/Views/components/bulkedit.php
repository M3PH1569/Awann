<div id="bulkEditModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-xl w-[90%] md:w-[500px] overflow-hidden">

        <div class="flex justify-between items-center bg-[#1C4D8D] text-white px-4 py-3">
            <h3 class="font-bold">
                <i class="fa-solid fa-pen-to-square mr-1"></i>
                Edit Perangkat - <span id="bulkEditCount">0</span> Perangkat
            </h3>
            <button type="button" onclick="closeModal('bulkEditModal')" class="hover:text-gray-300 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="bulkEditForm" class="p-4 flex flex-col gap-4">
            <?= csrf_field() ?>
            <!-- Selected IDs (hidden, populated by JS) -->
            <input type="hidden" name="ids" id="bulk_ids">

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-xs text-blue-800">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    Hanya field yang diisi akan diupdate. Field kosong tidak akan mengubah data yang ada.
                </p>
            </div>

            <!-- Scrollable selected items preview -->
            <div>
                <label class="block text-sm font-medium text-[#1C4D8D] mb-1">Data yang dipilih:</label>
                <div id="bulkSelectedList"
                    class="max-h-24 overflow-y-auto bg-gray-50 rounded-md p-2 text-xs text-gray-600 border"></div>
            </div>

            <hr>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#1C4D8D]">Nama User</label>
                    <select id="bulk_user" name="id_users">
                        <option value="">Pilih User</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u['id'] ?>">
                                <?= $u['nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#1C4D8D]">Status</label>
                    <select id="bulk_status" name="status_mutasi">
                        <option value="">Pilih Status</option>
                        <?php foreach ($statuses as $s): ?>
                            <option value="<?= $s ?>">
                                <?= $s ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="font-medium text-[#1C4D8D] text-sm mb-2">Keterangan</label>
                <textarea id="bulk_ket" name="keterangan" rows="3" placeholder="Masukkan keterangan"
                    class="w-full border rounded-sm p-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1C4D8D] resize-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-1">
                <button type="button" onclick="closeModal('bulkEditModal')"
                    class="bg-[#D9D9D9] text-[#1C4D8D] text-sm px-3 py-2 rounded-md font-semibold shadow hover:bg-[#EFEFEF] transition">Batal</button>
                <button type="submit" id="btn_submit_bulk"
                    class="bg-[#1C4D8D] text-white text-sm px-4 py-2 rounded-md font-semibold shadow hover:bg-[#3E679E] transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>