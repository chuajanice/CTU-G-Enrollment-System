const addressSelect = document.getElementById("address");

let selectedProvince = "";
let selectedMunicipality = "";

// Load provinces from PSGC API
async function loadProvinces() {
  const response = await fetch("https://psgc.gitlab.io/api/provinces/");
  const provinces = await response.json();
  provinces.sort((a, b) => a.name.localeCompare(b.name));
  addressSelect.innerHTML = '<option value="" disabled selected>Address</option>';
  provinces.forEach(province => {
    const option = document.createElement("option");
    option.value = province.code;
    option.textContent = province.name;
    addressSelect.appendChild(option);
  });
}

loadProvinces();

addressSelect.addEventListener("change", async () => {
  const selected = addressSelect.value;

  // Province selected
  if (!selectedMunicipality && selected) {
    selectedProvince = addressSelect.options[addressSelect.selectedIndex].text;

    const response = await fetch(`https://psgc.gitlab.io/api/provinces/${selected}/cities-municipalities/`);
    const municipalities = await response.json();
    municipalities.sort((a, b) => a.name.localeCompare(b.name));

    addressSelect.innerHTML = '<option value="" disabled selected>Select Municipality</option>';
    municipalities.forEach(mun => {
      const option = document.createElement("option");
      option.value = mun.code;
      option.textContent = mun.name;
      addressSelect.appendChild(option);
    });

    selectedMunicipality = "loading";
  } 

  // Municipality selected
  else if (selectedMunicipality === "loading") {
    const munCode = selected;
    selectedMunicipality = addressSelect.options[addressSelect.selectedIndex].text;

    const response = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${munCode}/barangays/`);
    const barangays = await response.json();
    barangays.sort((a, b) => a.name.localeCompare(b.name));

    addressSelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';
    barangays.forEach(brgy => {
      const option = document.createElement("option");
      option.value = brgy.name;
      option.textContent = brgy.name;
      addressSelect.appendChild(option);
    });
  } 

  // Barangay selected
  else {
    const selectedBarangay = addressSelect.options[addressSelect.selectedIndex].text;
    const fullAddress = `${selectedBarangay}, ${selectedMunicipality}, ${selectedProvince}`;

    addressSelect.innerHTML = "";
    const finalOption = document.createElement("option");
    finalOption.value = fullAddress;
    finalOption.textContent = fullAddress;
    addressSelect.appendChild(finalOption);
    addressSelect.selectedIndex = 0;
  }
});


