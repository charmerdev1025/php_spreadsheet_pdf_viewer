const viewerElement = document.getElementById('viewer');
var index = 0;
var countNum = 0;
var numPerPage = [];
var total = 0;
WebViewer(
  {
    path: './lib',
    initialDoc: $(".filename").val(),
  },
  viewerElement
).then(instance => {
  samplesSetup(instance);
  const { annotationManager, documentViewer, Annotations } = instance.Core;

  const searchListener = (searchPattern, options, results) => {
    // add redaction annotation for each search result
    const newAnnotations = results.map(result => {
      const annotation = new Annotations.RedactionAnnotation();
      annotation.PageNumber = result.pageNum;
      annotation.Quads = result.quads.map(quad => quad.getPoints());
      annotation.StrokeColor = new Annotations.Color(136, 39, 31);
      return annotation;
    });

    annotationManager.addAnnotations(newAnnotations);
    annotationManager.drawAnnotationsFromList(newAnnotations);
  };

  documentViewer.addEventListener('documentLoaded', () => {
    const searchPattern = 'route';
    // searchPattern can be something like "search*m" with "wildcard" option set to true
    // searchPattern can be something like "search1|search2" with "regex" option set to true

    // options default values are false
    const searchOptions = {
      caseSensitive: false,  // match case
      wholeWord: true,      // match whole words only
      wildcard: false,      // allow using '*' as a wildcard value
      regex: false,         // string is treated as a regular expression
      searchUp: false,      // search from the end of the document upwards
      ambientString: false,  // return ambient string as part of the result
    };

    
    // start search after document loads
    document.querySelectorAll('.buttonCtl').forEach(btn => {
      btn.addEventListener('click', () => {
        instance.UI.addSearchListener(searchListener);
        instance.UI.searchTextFull(document.getElementById('searchWords').value, searchOptions);
        instance.UI.removeSearchListener(searchListener);
      })
    })
    document.getElementById('searchPage').innerText = 1 + ' to ' + documentViewer.getPageCount();
    instance.UI.addSearchListener(searchListener);
    instance.UI.searchTextFull(document.getElementById('searchWords').value, searchOptions);
    instance.UI.removeSearchListener(searchListener);   
  });
});
