import {fetch, translate, config} from './translate.js';

config.language = localStorage.getItem("lang") || "sk";
config.defaultUrl = window.rootUrl;

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
