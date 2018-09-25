window.addEventListener('load', function () {
  if (__gaTracker) {
    var phoneNumberEl = document.querySelector('.dealer-phone-number');
    if (phoneNumberEl) {
      phoneNumberEl.addEventListener('click', function () {
        var dealerName = phoneNumberEl.getAttribute('data-dealerName');
        var dealerPhone = phoneNumberEl.getAttribute('data-dealerPhone');
        if (dealerName && dealerPhone) {
          __gaTracker('send', 'event', 'Contact Info - Phone Number', 'View', dealerPhone + ' (' + dealerName + ')');
          var parent = phoneNumberEl.parentNode;
          phoneNumberEl.remove();
          parent.appendChild(document.createTextNode(dealerPhone));
        }
      });
    }

    var faxNumberEl = document.querySelector('.dealer-fax-number');
    if (faxNumberEl) {
      faxNumberEl.addEventListener('click', function () {
        var dealerName = faxNumberEl.getAttribute('data-dealerName');
        var dealerFax = faxNumberEl.getAttribute('data-dealerFax');
        if (dealerName && dealerFax) {
          __gaTracker('send', 'event', 'Contact Info - Fax Number', 'View', dealerFax + ' (' + dealerName + ')');
          var parent = faxNumberEl.parentNode;
          faxNumberEl.remove();
          parent.appendChild(document.createTextNode(dealerFax));
        }
      });
    }
  }
});
