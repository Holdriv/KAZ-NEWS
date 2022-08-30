let commentDiv = document.getElementById("comments")
const addBtn = document.getElementById("add-comment")
const textarea = document.getElementById("comment-text")

const authorBlogId = document.body.dataset.authorblog
const baseurl = document.body.dataset.baseurl
const blogId = document.body.dataset.blogid

const currentUserId = localStorage.getItem("user_id")

const getComments = () =>{
    axios.get(`${baseurl}/api/comments/list.php?id=${blogId}`)
    .then(res=>{
        showComment(res.data)
    })
}

const showComment = (comments) =>{
    let commentHTML = `<h2> ${comments.length} комментария </h2>`
    
    for(let i = 0; i < comments.length; i++){
        let deleteBtn = ``
        if(currentUserId == authorBlogId 
            || currentUserId == comments[i].author_id){
                deleteBtn = `
                <button onclick='removeComment(${comments[i].id})' class='delete-btn'>
                    Delete 
                </button>
                `
            }
        commentHTML += `
        <div class="comment">
            <div class="comment-header">
                <div>
                    <img src="images/avatar.png" alt="">
                    ${comments[i].full_name}
                </div>
                ${deleteBtn}
            </div>
            <p>${comments[i].text}</p>
        </div>
        `
    }
    commentDiv.innerHTML = commentHTML
}




getComments()

addBtn.onclick = function(){
    axios.post(`${baseurl}/api/comments/add.php`, {
        text:textarea.value,
        blog_id:blogId,
        author_id:currentUserId
    }).then(res=>{
        getComments()
        textarea.value = ""
    })
}

function removeComment(id){
    axios.delete(`${baseurl}/api/comments/delete.php?id=${id}`)
    .then(res=>{
        getComments()
    })
}