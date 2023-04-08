/* show login or signup  */

let titleForm = document.querySelectorAll(".title span");

document.querySelectorAll(".title span").forEach((ti, i) => {
    document.querySelectorAll(".frm form").forEach((f, j) => {
        ti.addEventListener("click", (e) => {

            titleForm.forEach(l => {
                l.classList.remove("activeL")
            })

            e.currentTarget.classList.add("activeL");

            if (i == j) {
                f.classList.remove("sh");
            }
            document.querySelectorAll(".frm form").forEach((l, k) => {
                if (i != k) {
                    l.classList.add("sh");
                }
            })
        })
    })
})
/*

*/
document.querySelectorAll(".order").forEach(el => {
    el.addEventListener("click", () => {
        alert("Food Has Been added in your Shopping Cart");
    })
})
