import { WebApp, Component, EventManager } from './modules/app.js';

// Required to initialize our web app
const app = new WebApp();

// Example of creating a new component with dummy data
// And rendering it to the page
const main = app.component({
    name: "Main",
    selector: "#DemoArea",
    template: "#FooBar",
    data: {
        title: "CPSC431 Final Demo Page",
        buttons: [
            { msg: "Hello", displayText: "Say Hi" },
            { msg: "Goodbye my firend", displayText: "Say Bye" }
        ]
    }
});

main.render("replace");



// Example of adding a regular click event
app.events.click("bar", (e) => {

    const src = e.target;
    const message = src.dataset.message ?? "NO MESSAGE!";
    alert(message);
});





// new code start from here 
document.addEventListener("AddListForm",  async(e) => {
        let entries = e.detail;
        let result = await app.POST("api/list.php", entries);

        closeModal();

    }, { once: true });

    cmp.render ("add", "beforeend");

    app.events.click( "closeModal", async(e) => {

        closeModal();
});



app.events.click("downlaodList", async (e) => {
    let src = e.target;
    let idx = src.dataset.idx ?? 0 ;

    if (idx < 1 ) return false;

    let items = await app.GET(`api/list.php?idx=${idx}`);  //itemDatafromDB
    let list = document.querySelector(`#list_${idx}`);

    list.classList.remove("hidden");

    items.forEach((item)=> {

        // let listItemTemplate = `
        // <li>
        //     <input type="checkbox" name="checked">  
        //     ${item.text}
        //     <button type='button' data-idx = "${item.idx}"  data-click = 'deleteItem' > Delete Item #${index +1} </button>
        // </li> `;

        // const myDiv = document.getElementById ("toggleList");
        list.insertAdjacentHTML ("beforeend",  `<li> ${item} </li>` );
        src.dataset.click = "toggleList"; 
    });

});


app.events.click("toggleList", async (e) => {

    let src = e.target;
    let idx = src.dataset.idx ?? 0 ;

    if (idx <1 ) return false; 

    let selector = `#list_${id}`;

    let target = document.querySelector(selector) ;

    target.classList.toggle("hidden");
});


(async () => {

    //get data from DB, turn in javascript object
    let lists = await app.GET("api/test.php");

    let comp = app.component({
        name: "Lists",
        selector: "#ListSummaries",
        template: "#ListSummariesTemplate", 
        data: lists
    });
    comp.render();
})();

