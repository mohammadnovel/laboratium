var simplemaps_countrymap_mapdata={
  main_settings: {
    //General settings
		width: "responsive", //or 'responsive'
    background_color: "#FBFAFC",
    background_transparent: "yes",
    border_color: "#FFF",
    pop_ups: "detect",
    
		//State defaults
		state_description: "",
    state_color: "#FBFAFC",
    state_hover_color: "#3B729F",
    state_url: "",
    border_size: 0,
    all_states_inactive: "no",
    all_states_zoomable: "no",
    
		//Location defaults
		location_description: "Location description",
    location_url: "",
    location_color: "#FFEE77",
    location_opacity: 1,
    location_hover_opacity: 1,
    location_size: 20,
    location_type: "circle",
    location_image_source: "frog.png",
    location_border_color: "#FFFFFF",
    location_border: 1,
    location_hover_border: 2.5,
    all_locations_inactive: "no",
    all_locations_hidden: "no",
    
		//Label defaults
		label_color: "#d5ddec",
    label_hover_color: "#d5ddec",
    label_size: 22,
    label_font: "Arial",
    hide_labels: "no",
    hide_eastern_labels: "no",
   
		//Zoom settings
		zoom: "false",
    manual_zoom: "false",
    back_image: "no",
    initial_back: "no",
    initial_zoom: "-1",
    initial_zoom_solo: "no",
    region_opacity: 1,
    region_hover_opacity: 0.6,
    zoom_out_incrementally: "yes",
    zoom_percentage: 0.99,
    zoom_time: 0.5,
    
		//Popup settings
		popup_color: "white",
    popup_opacity: 0.9,
    popup_shadow: 1,
    popup_corners: 5,
    popup_font: "12px/1.5 Verdana, Arial, Helvetica, sans-serif",
    popup_nocss: "no",
    
		//Advanced settings
		div: "map",
    auto_load: "yes",
    url_new_tab: "no",
    images_directory: "default",
    fade_time: 0.1,
    link_text: "View Website"
  },
  state_specific: {
    IDN1136: {
      name: "Aceh",
      description: "default",
      color: "default",
      hover_color: "default",
      url: "default"
    },
    IDN1185: {
      name: "Kalimantan Timur"
    },
    IDN1223: {
      name: "Jawa Barat"
    },
    IDN1224: {
      name: "Jawa Tengah"
    },
    IDN1225: {
      name: "Bengkulu"
    },
    IDN1226: {
      name: "Banten"
    },
    IDN1227: {
      name: "Jakarta Raya"
    },
    IDN1228: {
      name: "Kalimantan Barat"
    },
    IDN1229: {
      name: "Lampung"
    },
    IDN1230: {
      name: "Sumatera Selatan"
    },
    IDN1231: {
      name: "Bangka-Belitung"
    },
    IDN1232: {
      name: "Bali"
    },
    IDN1233: {
      name: "Jawa Timur"
    },
    IDN1234: {
      name: "Kalimantan Selatan"
    },
    IDN1235: {
      name: "Nusa Tenggara Timur"
    },
    IDN1236: {
      name: "Sulawesi Selatan"
    },
    IDN1237: {
      name: "Sulawesi Barat"
    },
    IDN1796: {
      name: "Kepulauan Riau"
    },
    IDN1837: {
      name: "Gorontalo"
    },
    IDN1930: {
      name: "Jambi"
    },
    IDN1931: {
      name: "Kalimantan Tengah"
    },
    IDN1933: {
      name: "Irian Jaya Barat"
    },
    IDN381: {
      name: "Sumatera Utara"
    },
    IDN492: {
      name: "Riau"
    },
    IDN513: {
      name: "Sulawesi Utara"
    },
    IDN538: {
      name: "Maluku Utara"
    },
    IDN539: {
      name: "Sumatera Barat"
    },
    IDN540: {
      name: "Yogyakarta"
    },
    IDN554: {
      name: "Maluku"
    },
    IDN555: {
      name: "Nusa Tenggara Barat"
    },
    IDN556: {
      name: "Sulawesi Tenggara"
    },
    IDN557: {
      name: "Sulawesi Tengah"
    },
    IDN558: {
      name: "Papua"
    }
  },
  locations: dataLocations
};
$(function(){
  $("body").delegate('[class*="sm_location"]', 'click', function(){
    var className = $(this).attr('class'),
        inputName = className.replace('sm_location_',''),
        data = dataLocations[inputName];

    if (data.url == null || data.url == '') return false;
    location.href = data.url;
  });
});