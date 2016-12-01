package com.thomsonreuters.injection;

import com.google.inject.Singleton;

import com.netflix.governator.annotations.Modules;

import com.thomsonreuters.handler.HealthCheck;
import com.thomsonreuters.injection.module.MainModule;
import com.thomsonreuters.karyon.JerseyBasicRoutingModule;

import netflix.karyon.KaryonBootstrap;
import netflix.karyon.archaius.ArchaiusBootstrap;

@ArchaiusBootstrap
@KaryonBootstrap(name = "metacatalog-service", healthcheck = HealthCheck.class)
@Singleton
@Modules(include = { 
//	ShutdownModule.class,
//	KaryonServoModule.class,
//	KaryonWebAdminModule.class,
//	KaryonEurekaModule.class,
//	EventsModule.class,
	MainModule.class,
	BootstrapInjectionModule.KaryonRxRouterModuleImpl.class, 
})
public interface BootstrapInjectionModule {
	
	class KaryonRxRouterModuleImpl extends JerseyBasicRoutingModule {
		
		public KaryonRxRouterModuleImpl() {
			// default constructor
		}
		
		@Override
		protected void configureServer() {
			super.configureServer();
		}
	}
}
