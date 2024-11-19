window.addEventListener('DOMContentLoaded', function () {

  // Select the node to be observed
  let targetNode = document.querySelector('.tagManagerManageEdit');

  if (targetNode) {

    // Options for the observer (which mutations to observe)
    const config = {attributes: true, childList: true, subtree: true};

    // Callback function to execute when mutations are observed
    const callback = (mutationList, observer) => {
      for (const mutation of mutationList) {
        if (mutation.type === 'childList') {
          mutation.addedNodes.forEach(node => {
            if (node.nodeType === 1) {
              const textarea = node.querySelector("#customHtml");
              if (textarea) {
                editorFromTextArea(textarea);
              }
            }
          });
        }
      }
    };

    // Create an observer instance linked to the callback function
    const observer = new MutationObserver(callback);

    // Start observing the target node for configured mutations
    observer.observe(targetNode, config);


    function editorFromTextArea(textarea) {
      textarea.rows = 8;
      textarea.spellcheck = false;
    }
  }

});
