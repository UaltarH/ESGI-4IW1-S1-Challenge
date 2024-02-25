import $ from "jquery";

document.addEventListener("DOMContentLoaded", function () {
    const componentList = document.getElementById("componentList");
    const componentsAddedList = document.getElementById("componentsAddedList");

    if(!componentList || !componentsAddedList) {
        return;
    }
    componentList.addEventListener("change", function (event) {  
        //clear componentsAddedList
        componentsAddedList.innerHTML = "";
        
        // Parcourez toutes les cases à cocher cochées
        const checkedCheckboxes = Array.from(componentList.querySelectorAll('input[type="checkbox"]:checked'));

        checkedCheckboxes.forEach(function (checkedCheckbox) {
            // Créez un élément li pour chaque case à cocher cochée
            const li = document.createElement("li");
            li.dataset.id = checkedCheckbox.value;
            li.textContent = checkedCheckbox.nextElementSibling.textContent;


            // Créez un élément input de type number
            const inputNumber = document.createElement("input");
            inputNumber.type = "number";
            inputNumber.min = "1";         
            inputNumber.value = checkedCheckbox.dataset.price;   

            // Ajoutez l'input number au li
            li.appendChild(inputNumber);

            // Ajoutez le li à la liste des composants ajoutés
            componentsAddedList.appendChild(li);
        });
    });
});

$(document).ready(function () {    
    $("#btnAddComponents").click(function () {        
        const componentsAddedList = $("#componentsAddedList");
        const componentsValues = {};
        
        componentsAddedList.find("li").each(function () {            
            const componentId = this.dataset.id;            
            const componentPrice = $(this).find("input[type='number']").val();
            
            componentsValues[componentId] = componentPrice;
        });
        if(Object.keys(componentsValues).length === 0) {
            return;
        }
        const pasthSplited = window.location.pathname.split("/");
        const productId = pasthSplited[pasthSplited.length - 1];
        const bodyResquest = {
            product: productId,
            components: componentsValues
        };       
        $.ajax({
            url: '/products/manager/componentpost',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(bodyResquest),
            success: function (response) {                
                if(response.status == "success") {
                    window.location.href = '/products/manager';
                } else {
                    console.error(response);
                }
            },
            error: function (error) {                
                console.error(error);
            }
        });
    });
});