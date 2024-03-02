import $ from "jquery";
document.addEventListener("DOMContentLoaded", function () {
  var onPageCreateQuotation = document.getElementById("articleQuotation");
  if (onPageCreateQuotation) {
    //add event click for the buttons
    var buttonAddService = document.getElementById("buttonAddService");
    buttonAddService.addEventListener("click", addServiceItem);

    // add event click for the button create quotation
    var buttonActionQuotation = document.getElementById(
      "buttonActionQuotation"
    );
    buttonActionQuotation.addEventListener("click", actionQuotation);

    // functions
    function actionQuotation() {
      // basic infos
      var clientSelect = document.getElementById("clientSelect");
      var productSelect = document.getElementById("selectProduct");
      var descriptionQuotation = document.getElementById(
        "descriptionQuotation"
      );
      var discountValue = document.getElementById("discountInput").value;
      if (descriptionQuotation.value === "") {
        alert("La description du devis ne peut pas être vide.");
        return;
      }

      // price
      var finalPrice = 0;
      var valueAfterDiscount = document.getElementById(
        "finalPriceAfterDiscount"
      ).textContent;
      if (valueAfterDiscount != "0.00 €") {
        finalPrice = valueAfterDiscount.replace("€", "").trim();
      } else {
        var valueTTC = document.getElementById("finalPriceTTC").textContent;
        finalPrice = valueTTC.replace("€", "").trim();
      }
      // alert if the price is empty
      if (finalPrice === "0.00") {
        alert("Le prix du devis ne peut pas être égal à 0.00 €.");
        return;
      }

      // services
      var services = [];
      var containerService = document.getElementById("containerService");
      var serviceItems = containerService.querySelectorAll(".serviceItem");
      // remove item origin
      serviceItems = Array.from(serviceItems).filter(function (item) {
        return !item.classList.contains("hidden");
      });

      serviceItems.forEach(function (serviceItem) {
        // get the number of the serviceItem
        var numberItem = serviceItem.id.split("-")[1];

        // get the value of the select service
        var selectService = serviceItem.querySelector(
          "#selectService-" + numberItem
        );
        var selectedServiceValue = selectService.value;

        // get the value of the component select if the service is 'Achat composants'
        var selectedComponentValue = "";
        var selectedValueText =
          selectService.options[selectService.selectedIndex].text;
        if (selectedValueText === "Achat composants") {
          var selectComponent = serviceItem.querySelector(
            "#selectComponent-" + numberItem
          );
          selectedComponentValue = selectComponent.value;
        }

        // get the price of the service
        var priceService = serviceItem.querySelector(
          "#servicePrice-" + numberItem
        ).value;

        services.push({
          serviceId: selectedServiceValue,
          componentId: selectedComponentValue,
          price: priceService,
        });
      });

      if (editQuotationBoolean === false) {
        // create the json object to send
        var createQuotation = {
          clientId: clientSelect.value,
          productId: productSelect.value,
          description: descriptionQuotation.value,
          discount: discountValue,
          price: finalPrice,
          services: services,
        };
        sendNewQuotation(createQuotation);
      } else {
        var editQuotation = {
          id: quotationId,
          price: finalPrice,
          description: descriptionQuotation.value,
          discount: discountValue,
          services: services,
        };
        sendEditQuotation(editQuotation);
      }
    }

    function sendEditQuotation(editQuotation) {
      console.log(JSON.stringify(editQuotation, null, 2));

      // send the json object to the server
      $.ajax({
        url: "/quotation/editpost",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(editQuotation),
        success: function (response) {
          console.log(response);
          if (response.status == "success") {
            $.ajax({
              url: "/quotation/pdfpost",
              type: "POST",
              contentType: "application/json",
              data: JSON.stringify({ quotationId: response.quotationId }),
              success: function (response) {
                console.log(response);
                if (response.status == "success") {
                  window.location.href = "/quotation/manager";
                } else {
                  console.error(response);
                }
              },
              error: function (error) {
                console.error("Erreur lors de la requête Ajax :", error);
              },
            });
          } else {
            console.error(response);
          }
        },
        error: function (error) {
          console.error("Erreur lors de la requête Ajax :", error);
        },
      });
    }

    function sendNewQuotation(createQuotation) {
      console.log(JSON.stringify(createQuotation, null, 2));

      // send the json object to the server
      $.ajax({
        url: "/quotation/create/post",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(createQuotation),
        success: function (response) {
          console.log(response);
          if (response.status == "success") {
            // redirect to the home page
            // window.location.href = "/quotation/manager";
            // call ajax to create the pdf with the id of the quotation
            $.ajax({
              url: "/quotation/pdfpost",
              type: "POST",
              contentType: "application/json",
              data: JSON.stringify({ quotationId: response.quotationId }),
              success: function (response) {
                console.log(response);
                if (response.status == "success") {
                  window.location.href = "/quotation/manager";
                } else {
                  console.error(response);
                }
              },
              error: function (error) {
                console.error("Erreur lors de la requête Ajax :", error);
              },
            });
          } else {
            console.error(response);
          }
        },
        error: function (error) {
          console.error("Erreur lors de la requête Ajax :", error);
        },
      });
    }

    function addServiceItem() {
      var lenghtServices =
        document.getElementById("containerService").childElementCount;

      var serviceItemOrigin = document.getElementById("serviceItem-origin");
      var clonedServiceItem = serviceItemOrigin.cloneNode(true);

      // specifies unique id for the cloned element
      var numberItem = lenghtServices;
      let uniqueId = "serviceItem-" + numberItem;

      // test if the element already exist
      var existingElement = document.getElementById(uniqueId);
      if (existingElement) {
        for (var i = 2; i <= 50; i++) {
          uniqueId = "serviceItem-" + i;
          var existingElement = document.getElementById(uniqueId);

          if (!existingElement) {
            numberItem = i;
            break;
          }
        }
      }

      clonedServiceItem.id = uniqueId;
      var buttonRemoveService = clonedServiceItem.querySelector(
        "#removeService-origin"
      );
      buttonRemoveService.id = "removeService-" + numberItem;

      var selectService = clonedServiceItem.querySelector(
        "#selectService-origin"
      );
      selectService.id = "selectService-" + numberItem;

      var selectComponent = clonedServiceItem.querySelector(
        "#selectComponent-origin"
      );
      selectComponent.id = "selectComponent-" + numberItem;

      var selectComponentDiv = clonedServiceItem.querySelector(
        "#selectComponentDiv-origin"
      );
      selectComponentDiv.id = "selectComponentDiv-" + numberItem;

      var inputPrice = clonedServiceItem.querySelector("#servicePrice-origin");
      inputPrice.id = "servicePrice-" + numberItem;

      // remove hidden class of the item origin
      clonedServiceItem.classList.remove("hidden");

      // add new element cloned to the container
      document
        .getElementById("containerService")
        .appendChild(clonedServiceItem);

      // add event for the select of services
      setEventSelectService(numberItem);

      // add event for the input price of the service
      setEventInputPriceService(numberItem);

      // add event for the button remove service
      setEventRemoveService(numberItem);
    }

    function removeContendService(element) {
      var parentContendService = element.closest(".serviceItem");

      if (parentContendService) {
        parentContendService.remove();
      }

      // update the final price
      updateFinalPrice();
    }

    function updateFinalPrice() {
      var finalPriceHT = document.getElementById("finalPriceHT");
      var finalPriceTTC = document.getElementById("finalPriceTTC");
      var finalPriceAfterDiscount = document.getElementById(
        "finalPriceAfterDiscount"
      );

      var containerService = document.getElementById("containerService");
      var inputsServices = containerService.querySelectorAll("input");

      var total = 0;

      inputsServices.forEach(function (input) {
        total += parseFloat(input.value) || 0;
      });

      finalPriceHT.textContent = total.toFixed(2) + " €";
      var priceTTC = (total * 1.2).toFixed(2);
      finalPriceTTC.textContent = priceTTC + " €";

      var discountInput = document.getElementById("discountInput");
      if (discountInput.value) {
        var discountPourcentage = parseFloat(discountInput.value);
        var discount = (priceTTC * discountPourcentage) / 100;
        finalPriceAfterDiscount.textContent =
          (priceTTC - discount).toFixed(2) + " €";
      }
    }

    //create event click for the button remove service
    function setEventRemoveService(numberItem) {
      var buttonRemoveService = document.getElementById(
        "removeService-" + numberItem
      );
      buttonRemoveService.addEventListener("click", function () {
        removeContendService(buttonRemoveService);
      });
    }

    // gestion des select (event)
    function setEventSelectService($itemNumber) {
      var selectService = document.getElementById(
        "selectService-" + $itemNumber
      );

      selectService.addEventListener("change", function () {
        var selectedValue =
          selectService.options[selectService.selectedIndex].text;

        var selectComponentDiv = document.getElementById(
          "selectComponentDiv-" + $itemNumber
        );

        if (selectedValue === "Achat composants") {
          selectComponentDiv.classList.remove("hidden");
        } else {
          selectComponentDiv.classList.add("hidden");
        }
      });
    }

    // gestion du select des produits (event)
    function setEventSelectProduct() {
      var selectProduct = document.getElementById("selectProduct");
      selectProduct.addEventListener("change", function () {
        var productSelected =
          selectProduct.options[selectProduct.selectedIndex].text;

        // remove all serviceItems sauf le premier et le origin
        var containerService = document.getElementById("containerService");
        for (var i = 2; i <= containerService.children.length + 1; i++) {
          var itemService = containerService.querySelector("#serviceItem-" + i);
          if (itemService) {
            containerService.removeChild(itemService);
          }
        }

        // update the selectItem origin and selectItem 1 with the new product component associated
        // update the select component
        var componentsProductSelected = productsAndComponentsAssociated.find(
          function (item) {
            return item.product.id === selectProduct.value;
          }
        ).product.components;

        var selectComponentsOrigin = document.getElementById(
          "selectComponent-origin"
        );
        var selectComponents1 = document.getElementById("selectComponent-1");

        selectComponentsOrigin.innerHTML = "";
        selectComponents1.innerHTML = "";

        componentsProductSelected.forEach(function (component) {
          var option = document.createElement("option");
          option.value = component.id;
          option.textContent = component.name;
          selectComponentsOrigin.appendChild(option);
        });

        componentsProductSelected.forEach(function (component) {
          var option = document.createElement("option");
          option.value = component.id;
          option.textContent = component.name;
          selectComponents1.appendChild(option);
        });

        // reset input price itemService 1
        var inputPrice1 = document.getElementById("servicePrice-1");
        inputPrice1.value = "";

        // update price
        updateFinalPrice();
      });
    }

    // gestion des inputs price des services (event)
    function setEventInputPriceService($itemNumber) {
      var inputPrice = document.getElementById("servicePrice-" + $itemNumber);
      inputPrice.addEventListener("change", function () {
        var priceService = inputPrice.value;

        // update the final price
        updateFinalPrice();
      });
    }

    // add event for the discount input
    function setEventDiscountInput() {
      var discountInput = document.getElementById("discountInput");
      discountInput.addEventListener("change", function () {
        var liPriceAfterDiscount = document.getElementById(
          "liPriceAfterDiscount"
        );
        if (discountInput.value) {
          liPriceAfterDiscount.classList.remove("hidden");
        } else {
          liPriceAfterDiscount.classList.add("hidden");
          var finalPriceAfterDiscount = document.getElementById(
            "finalPriceAfterDiscount"
          );
          finalPriceAfterDiscount.textContent = "0.00 €";
        }
        updateFinalPrice();
      });
    }
    // init event for the first item service
    setEventSelectService(1);
    setEventInputPriceService(1);

    // init event select product and discount input
    setEventDiscountInput();
    setEventSelectProduct();
  }
});
