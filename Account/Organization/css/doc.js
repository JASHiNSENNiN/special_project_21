document.addEventListener("DOMContentLoaded", function () {
  if (document.getElementById("editor-container")) {
    var editor = new Quill("#editor-container", {
      modules: {
        toolbar: [
          [{ header: [1, 2, false] }],
          ["bold", "italic", "underline"],
          [{ list: "ordered" }, { list: "bullet" }],
        ],
      },
      placeholder: "Create a detailed job description",
      theme: "snow",
    });

    var quillEditor = document.getElementById("description");

    editor.on("text-change", function () {
      quillEditor.value = editor.root.innerHTML;
    });

    quillEditor.addEventListener("input", function () {
      editor.root.innerHTML = quillEditor.value;
    });
  }
});
