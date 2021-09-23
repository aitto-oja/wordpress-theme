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
      this.deleteLike();
    } else {
      this.createLike();
    }
  }

  createLike() {
    alert("Create test message");
  }

  deleteLike() {
    alert("Delete test message");
  }
}

export default Like;
