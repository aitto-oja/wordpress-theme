import $ from "jquery";

class Search {
  // 1. Desctibe and create/initiate our object
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.events();
    this.isOverlayOpen = false;
    this.typingTimer;
  }

  // 2. Events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keydown", this.typingLogic.bind(this));
  }

  // 3. Methods

  typingLogic() {
    clearTimeout(this.typingTimer);
    this.typingTimer = setTimeout(function () {
      console.log("this is a timeout test");
    }, 2000);
  }

  keyPressDispatcher(e) {
    //   find out keycode
    // console.log(e.keyCode);
    // s == 83; esc == 27;

    // open search overlay if 's' is pressed
    if (e.keyCode == 83 && !this.isOverlayOpen) {
      this.openOverlay();
    }

    // close with esc
    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }
}

export default Search;
