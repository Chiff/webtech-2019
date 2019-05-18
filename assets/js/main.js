import { fetch, translate, config } from './translate.js';

config.language = 'en';
// TODO - 17.5.2019 - Temporary solution - NEED TO EDIT TO GET TRANSLATIONS WORK
// do not commit
config.defaultUrl = 'http://147.175.121.210:8153/Zaver/DNT';
// do not commit

if (!config.defaultUrl) {
	alert('Nastav si defaultUrl!');
} else {
	fetch()
		.then(data => {
			translate(data);
		})
		.catch(error => {
			console.warn(error);
			alert('nepodarilo sa stihanut preklad pre jazyk en');
		});
}
