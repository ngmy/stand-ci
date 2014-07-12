// resize an iframe height according to its content height
$(function () {
  // for an iframe of phpunit, coverage, and others
  $('#iframe-phpunit,#iframe-coverage,#iframe-phpdoc,#iframe-phpcs,#iframe-phpmd,#iframe-phpcpd,#iframe-metrics,#iframe-phpunit-overview,#iframe-phpcs-overview,#iframe-phpmd-overview').load(function () {
    var $self = $(this);
    setInterval(function () {
      var $html = $self.contents().find('html');
      var newHeight = $html.height();

      $self.height(newHeight + 20);
    }, 1);
  });

  // for an iframe of phpcb
  $('#iframe-phpcb').load(function () {
    var $self = $(this);
    setInterval(function () {
      var $body = $self.contents().find('body');
      var $tree = $self.contents().find('#treeContainer');
      var newHeight;

      if ($body.height() > $tree.height()) {
        newHeight = $body.height();
      } else {
        newHeight = $tree.height();
      }

      $self.height(newHeight + 20);
    }, 1);
  });

  // trigger an iframe load event
  $('iframe').trigger('load');
});
