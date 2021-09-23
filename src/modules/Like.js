import $ from "jquery";

class Like {
  constructor() {
    this.events();
  }

  events() {
    $(".like-box").on("click", this.myClickDispatcher.bind(this));
  }

  // Methods
  myClickDispatcher() {
    if ($(".like-box").data("exists") == "yes") {
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
