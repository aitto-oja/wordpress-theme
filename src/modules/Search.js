import $ from "jquery";

class Search {
  // 1. Desctibe and create/initiate our object
  constructor() {
    this.addSearchTHML();
    this.resultDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousSearchValue;
    this.typingTimer;
  }

  // 2. Events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  // 3. Methods

  typingLogic() {
    if (this.searchField.val() != this.previousSearchValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultDiv.html("");
        this.isSpinnerVisible = false;
      }
    }
    this.previousSearchValue = this.searchField.val();
  }

  getResults() {
    $.getJSON(
      aittoojaData.root_url +
        "/wp-json/aittooja/v1/search?term=" +
        this.searchField.val(),
      (results) => {
        this.resultDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              results.generalInfo.length
                ? '<ul class="link-list min-list">'
                : "<p>No general information matches that search.</p>"
            } 
              ${results.generalInfo
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a> ${
                      item.postType == "post" ? `by ${item.authorName}` : ``
                    } </li>`
                )
                .join("")}
            ${results.generalInfo.length ? "</ul>" : ""}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Projects</h2>
            ${
              results.projects.length
                ? '<ul class="link-list min-list">'
                : `<p>No projects match that search. <a href="${aittoojaData.root_url}/projects">View all projects</a></p>`
            } 
              ${results.projects
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a></li>`
                )
                .join("")}
            ${results.projects.length ? "</ul>" : ""}
            <h2 class="search-overlay__section-title">Events</h2>
            ${
              results.events.length
                ? ""
                : `<p>No events match that search. <a href="${aittoojaData.root_url}/events">View all events</a>.</p>`
            } 
              ${results.events
                .map(
                  (item) =>
                    `
                    <div class="event-summary">
                      <a class="event-summary__date t-center" href="${item.permalink}">
                        <span class="event-summary__month">
                          ${item.month}
                        </span>
                        <span class="event-summary__day">${item.day}</span>
                      </a>
                      <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                        <p>
                          ${item.description} 
                          <a href="${item.permalink}" class="nu gray">Learn more</a>
                        </p>
                      </div>
                    </div>
                    `
                )
                .join("")}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Languages</h2>
            ${
              results.languages.length
                ? '<ul class="professor-cards">'
                : `<p>No languages match that search.</p>`
            } 
              ${results.languages
                .map(
                  (item) =>
                    `
                    <li class="professor-card__list-item">
                    <a class="professor-card" href="${item.permalink}">
                        <img class="professor-card__image" src="${item.image}">
                        <span class="professor-card__name">
                            ${item.title}
                        </span>
                    </a>
                </li>
                    `
                )
                .join("")}
            ${results.languages.length ? "</ul>" : ""}
            <h2 class="search-overlay__section-title">Frameworks</h2>
            ${
              results.frameworks.length
                ? '<ul class="professor-cards">'
                : `<p>No frameworks match that search.</p>`
            } 
              ${results.frameworks
                .map(
                  (item) =>
                    `
                    <li class="professor-card__list-item">
                    <a class="professor-card" href="${item.permalink}">
                        <img class="professor-card__image" src="${item.image}">
                        <span class="professor-card__name">
                            ${item.title}
                        </span>
                    </a>
                </li>
                    `
                )
                .join("")}
            ${results.frameworks.length ? "</ul>" : ""}
          </div>
        </div>
      `);
        this.isSpinnerVisible = false;
      }
    );
  }

  keyPressDispatcher(e) {
    //   find out keycode
    // console.log(e.keyCode);
    // s == 83; esc == 27;

    // open search overlay if 's' is pressed
    if (
      e.keyCode == 83 &&
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
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
    this.searchField.val("");
    setTimeout(() => this.searchField.trigger("focus"), 310);
    this.isOverlayOpen = true;
    return false;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.searchField.trigger("focusout");
    this.isOverlayOpen = false;
  }

  addSearchTHML() {
    $("body").append(`
      <div class="search-overlay">
        <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
        </div>
        <div class="container">
          <div id="search-overlay__results"></div>
        <div>
      </div>
    `);
  }
}

export default Search;
