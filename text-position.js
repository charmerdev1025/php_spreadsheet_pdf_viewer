const viewerElement = document.getElementById('viewer');
WebViewer(
  {
    path: './lib',
    initialDoc: $(".filename").val(),
  },
  viewerElement
).then(instance => {
  samplesSetup(instance);
  const { documentViewer, Annotations , Search } = instance.Core;

  documentViewer.setSearchHighlightColors({
    searchResult: new Annotations.Color(0, 0, 255, 0.5),
    activeSearchResult: 'rgba(0, 255, 0, 0.5)'
  });
  documentViewer.addEventListener('documentLoaded', () => { 
    let mode = Search.Mode.PAGE_STOP | Search.Mode.HIGHLIGHT | Search.Mode.WHOLE_WORD;
    const searchOptions = {
      fullSearch: false,
      onResult: result => {
        if (result.resultCode === Search.ResultCode.FOUND) {
          documentViewer.displaySearchResult(result);
          documentViewer.setActiveSearchResult(result); 
        }
      }
    };

    document.querySelectorAll('.buttonCtl').forEach(btn => {
      btn.addEventListener('click', () => {
        mode = btn.getAttribute("alt") === '1' ? Search.Mode.PAGE_STOP | Search.Mode.HIGHLIGHT | Search.Mode.WHOLE_WORD : Search.Mode.PAGE_STOP | Search.Mode.HIGHLIGHT | Search.Mode.WHOLE_WORD | Search.Mode.SEARCH_UP;
        highlightSearch();
      })
    })

    document.getElementById('searchPage').innerText = 1 + ' of ' + documentViewer.getPageCount();
    highlightSearch();

    function highlightSearch() {
      const searchText = document.getElementById('searchString').value;
      documentViewer.clearSearchResults();
      documentViewer.textSearchInit(searchText, mode, searchOptions);
    }
  });
});
