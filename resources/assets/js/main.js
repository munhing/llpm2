
import Vue from 'vue';

// register pages
Vue.component('AgentTopConf', require('./pages/agent_top_conf.vue'));
Vue.component('CargoMtConf', require('./pages/cargo_mt_conf.vue'));
Vue.component('CargoLooseMtConf', require('./pages/cargo_loose_mt_conf.vue'));
Vue.component('CargoContainerizedMtConf', require('./pages/cargo_containerized_mt_conf.vue'));
Vue.component('CargoTopImportConf', require('./pages/cargo_top_import_conf.vue'));
Vue.component('CargoOriginConf', require('./pages/cargo_origin_conf.vue'));
Vue.component('CargoDestinationConf', require('./pages/cargo_destination_conf.vue'));
Vue.component('TotalTeusConf', require('./pages/total_teus_conf.vue'));
Vue.component('TotalVesselConf', require('./pages/total_vessel_conf.vue'));
Vue.component('VesselTopConf', require('./pages/vessel_top_conf.vue'));
Vue.component('CargoTopExportConf', require('./pages/cargo_top_export_conf.vue'));
Vue.component('ConsigneeTopConf', require('./pages/consignee_top_conf.vue'));
Vue.component('ConsignorTopConf', require('./pages/consignor_top_conf.vue'));

// register components
Vue.component('selectYear', require('./components/selectyear.vue'));

new Vue({
	el: 'body',

	methods: {
		onSubmit: function(e) {
			console.log(e);
			this.$broadcast('onSubmit', e);
		}
	}


});