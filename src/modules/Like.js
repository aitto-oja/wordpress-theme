import $ from "jquery";

class Like {
  constructor() {
    this.events();
  }

  events() {
    $(".like-box").on("click", this.myClickDispatcher.bind(this));
  }

  // Methods
  myClickDispatcher(e) {
    var currentLikeBox = $(e.target).closest(".like-box");
    if (currentLikeBox.data("exists") == "yes") {
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }

  createLike(currentLikeBox) {
    $.ajax({
      url: aittoojaData.root_url + "/wp-json/aittooja/v1/manageLike",
      type: "POST",
      data: {
        likedId: currentLikeBox.data("like-id"),
        likedType: currentLikeBox.data("like-type"),
      },
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike() {
    $.ajax({
      url: aittoojaData.root_url + "/wp-json/aittooja/v1/manageLike",
      type: "DELETE",
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default Like;
