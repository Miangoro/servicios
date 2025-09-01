document.addEventListener('DOMContentLoaded', function () {
  Dropzone.autoDiscover = false;

  const previewTemplate = `
    <div class="dz-preview dz-file-preview w-100 h-100">
      <div class="dz-image w-100 h-100">
        <img data-dz-thumbnail class="w-100 h-100 object-fit-cover rounded" />
      </div>
    </div>
  `;

  const dropzone = new Dropzone("#dropzone-basic", {
    previewTemplate: previewTemplate,
    url: "/upload",
    paramName: "file",
    maxFiles: 1,
    maxFilesize: 2,
    acceptedFiles: "image/*",
    thumbnailWidth: null,
    thumbnailHeight: null,
  });

  // Si se intenta agregar otra, reemplaza la anterior
  dropzone.on("maxfilesexceeded", function (file) {
    this.removeAllFiles(); // quita la previa
    this.addFile(file);    // agrega la nueva
  });
});

//función para input nombre empleado
$(function () {
  // String Matcher function
  var substringMatcher = function (strs) {
    return function findMatches(q, cb) {
      var matches, substrRegex;
      matches = [];
      substrRegex = new RegExp(q, 'i');
      $.each(strs, function (i, str) {
        if (substrRegex.test(str)) {
          matches.push(str);
        }
      });

      cb(matches);
    };
  };


  // Basic
  // --------------------------------------------------------------------
  $('.typeahead').typeahead(
    {
      hint: !isRtl,
      highlight: true,
      minLength: 1
    },
    {
      name: 'states',
      source: substringMatcher(usuarios)
    }
  );

});