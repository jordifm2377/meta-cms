package com.thomsonreuters.server;

import com.netflix.governator.guice.BootstrapModule;

import com.thomsonreuters.injection.BootstrapInjectionModule;

import java.io.IOException;

import netflix.karyon.Karyon;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class ServerRunner {
	
	private static final Logger logger = LoggerFactory.getLogger("DiseaseService");
	
	public static void main(String[] args) throws IOException {
		
		logger.info("DISEASE Service is starting");
		
		Karyon.forApplication(BootstrapInjectionModule.class, (BootstrapModule[]) null).startAndWaitTillShutdown();
	}
}
