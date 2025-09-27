function show_hide_password(target){
	var input = document.getElementById('inputPassword');
	var input2 = document.getElementById('inputPassword2');
	if (input.getAttribute('type') == 'password') {
		target.classList.add('fa-eye-slash');
		target.classList.remove('fa-eye');
		input.setAttribute('type', 'text');
		if(input2)
			input2.setAttribute('type', 'text');
	} else {
		target.classList.add('fa-eye');
		target.classList.remove('fa-eye-slash');
		input.setAttribute('type', 'password');
		if(input2)
			input2.setAttribute('type', 'password');
	}
	return false;
}

const myTabs = document.querySelectorAll("ul.nav-tabs > li > a");  
const panes = document.querySelectorAll(".tab-pane");
const tabAction = Object.keys(myTabs).map((tab)=>{
	myTabs[tab].addEventListener("click", (e)=> {
             
		makeInactive(myTabs);
		activateTab(e);
		makeInactive(panes);
		activateTabContent(e);
                   
		e.preventDefault();
	});
});

function makeInactive(items) 
{
	const  content = Object.keys(items).map((item)=> {
		items[item].classList.remove("active");
	});                  
}

function activateTab(e) 
{                 
	const clickedTab = e.currentTarget;
	clickedTab.classList.add("active");                 
}
             
function activateTabContent(e) 
{                 
	const anchorReference = e.target;
	const activePaneID = anchorReference.getAttribute("href");
	const activePane = document.querySelector(activePaneID);
	activePane.classList.add("active");                     
}
