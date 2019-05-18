import {fetch, translate, config} from './translate.js';

config.language = localStorage.getItem("lang") || "sk";
// TODO - 17.5.2019 - Temporary solution - NEED TO EDIT TO GET TRANSLATIONS WORK
// config.defaultUrl = 'http://147.175.121.210:8153/Zaver/${TVOJ_FOLDER}';

if (!config.defaultUrl) {
	alert('Nastav si defaultUrl!');
} else {
	fetch()
		.then(data => {
			translate(data);
		})
		.catch(error => {
			console.warn(error);
			alert('nepodarilo sa stihanut preklad pre jazyk' + config.language );
		});
}

window.setLanguage = function (lang) {
	localStorage.setItem("lang", lang);
	location.reload();
};