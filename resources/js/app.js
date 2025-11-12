import "./bootstrap";
import * as FilePond from "filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageCrop from "filepond-plugin-image-crop";
import FilePondPluginImageTransform from "filepond-plugin-image-transform";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageCrop,
    FilePondPluginImageTransform,
    FilePondPluginFileValidateType
);

document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll("input.filepond");
    inputs.forEach((input) => {
        // Simpan nama asli input
        const fieldName = input.getAttribute("name") || "foto";

        const pond = FilePond.create(input, {
            allowMultiple: false,
            acceptedFileTypes: ["image/*"],
            allowImageCrop: true,
            imageCropAspectRatio: 9 / 10,
            allowImageTransform: true,
            labelIdle:
                'Drag & drop gambar atau <span class="filepond--label-action">Pilih</span> (Rasio 9:10)',
            storeAsFile: true,
        });

        const form = input.closest("form");
        if (form) {
            form.addEventListener("submit", (e) => {
                const files = pond.getFiles();

                if (files.length > 0) {
                    // Buat input file baru yang berisi file dari FilePond
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0].file);

                    // Cari atau buat input file dengan nama yang benar
                    let fileInput = form.querySelector(
                        `input[name="${fieldName}"][type="file"]`
                    );
                    if (!fileInput) {
                        fileInput = document.createElement("input");
                        fileInput.type = "file";
                        fileInput.name = fieldName;
                        fileInput.style.display = "none";
                        form.appendChild(fileInput);
                    }

                    fileInput.files = dataTransfer.files;
                }
            });
        }
    });
});
