const todos = document.querySelectorAll(".todo");
const all_status = document.querySelectorAll(".status");
let draggableTodo = null;

todos.forEach((todo) => {
  todo.addEventListener("dragstart", dragStart);
  todo.addEventListener("dragend", dragEnd);
});

function dragStart() {
  draggableTodo = this;
  setTimeout(() => {
    this.style.display = "none";
  }, 0);
  // console.log(draggableTodo);
  // console.log("Source div id : " + this.id);
}

function dragEnd() {
  draggableTodo = null;
  setTimeout(() => {
    this.style.display = "block";
  }, 0);
}

all_status.forEach((status) => {
  status.addEventListener("dragover", dragOver);
  status.addEventListener("dragenter", dragEnter);
  status.addEventListener("dragleave", dragLeave);
  status.addEventListener("drop", dragDrop);
});

function dragOver(e) {
  e.preventDefault();
    // console.log("dragOver");
}

function dragEnter() {
  this.style.border = "1px dashed #ccc";
  // console.log("dragEnter");
}

function dragLeave() {
  this.style.border = "none";
  // console.log("dragLeave");
}

function dragDrop() {
  console.log(draggableTodo.id);
  this.style.border = "none";
  this.appendChild(draggableTodo);

  console.log(this.id);
  let status_id = this.id;
  console.log(status_id);
  status_id = status_id.replace("status_", "");
  console.log(status_id);

  $("#loader_status_"+status_id).show();
  $.ajax({
    url:"action/update_status.php",
    type:'GET',
    data:"id="+draggableTodo.id+"&status_id="+status_id,
    success:function(){
      $("#loader_status_"+status_id).hide();
    }
  })
}

const btns = document.querySelectorAll("[data-target-modal]");
const close_modals = document.querySelectorAll(".close-modal");
const overlay = document.getElementById("overlay");

btns.forEach((btn) => {
  btn.addEventListener("click", () => {
    document.querySelector(btn.dataset.targetModal).classList.add("active");
    overlay.classList.add("active");
  });
});

close_modals.forEach((btn) => {
  btn.addEventListener("click", () => {
    const modal = btn.closest(".modal");
    modal.classList.remove("active");
    overlay.classList.remove("active");
  });
});

window.onclick = (event) => {
  if (event.target == overlay) {
    const modals = document.querySelectorAll(".modal");
    modals.forEach((modal) => modal.classList.remove("active"));
    overlay.classList.remove("active");
  }
};

function createTopic() {

  const input_val = document.getElementById("topic_input").value;
  const app_user_id = document.getElementById("app_user_id").value;

  var result = "false";

  if(input_val.trim() === "") {

    alert("Enter Topic Title");

  } else {

    $("#loader_status_1").show();

    $.ajax({
      url:"action/save_topic.php",
      type:'post',
      data:"app_user_id="+app_user_id+"&title="+input_val,
      success:function(){

        $("#loader_status_1").hide();
        result = "true";

      }
    })

    result = "true";

  }

  return result;

}

function createTodo() {

  const todo_div = document.createElement("div");
  const topic_id = document.getElementById("topic_input").value;
  const input_val = document.getElementById("todo_input").value;
  const app_user_id = document.getElementById("app_user_id").value;
  const txt = document.createTextNode(input_val);

  var result = "false";

  if(topic_id === "") {

    alert("Select topic");

  } else if(input_val.trim() === "") {

    alert("Enter Task Description");

  } else {

    $("#loader_status_1").show();
    
    $.ajax({
      url:"action/save.php",
      type:'post',
      data:"app_user_id="+app_user_id+"&topic_id="+topic_id+"&title="+input_val,
      success:function(){
        
        $("#loader_status_1").hide();

        todo_div.appendChild(txt);
        todo_div.classList.add("todo");
        todo_div.setAttribute("draggable", "true");

        /* create span */
        const span = document.createElement("span");
        const span_txt = document.createTextNode("\u00D7");
        span.classList.add("close");
        span.appendChild(span_txt);

        todo_div.appendChild(span);

        no_status.prepend(todo_div);
        // no_status.appendChild(todo_div);

        span.addEventListener("click", () => {
          span.parentElement.style.display = "none";
        });
        //   console.log(todo_div);

        todo_div.addEventListener("dragstart", dragStart);
        todo_div.addEventListener("dragend", dragEnd);

        //document.getElementById("todo_input").value = "";
        // todo_form.classList.remove("active");
        // overlay.classList.remove("active");

        document.getElementById("todo_input").value = "";
        //todo_form.classList.remove("active");
        //overlay.classList.remove("active");

        result = "true";
      }
    })

    result = "true";
    
  }
  
  return result;

}