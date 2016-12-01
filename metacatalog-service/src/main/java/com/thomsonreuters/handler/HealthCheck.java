package com.thomsonreuters.handler;

import com.google.inject.Singleton;

import javax.annotation.PostConstruct;

import netflix.karyon.health.HealthCheckHandler;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class HealthCheck implements HealthCheckHandler {
	
	private static final Logger logger = LoggerFactory.getLogger("DiseaseService");
	
	public HealthCheck() {
		// default constructor
	}
	
	@PostConstruct
	public void init() {
		logger.trace("Health Check initialized");
	}
	
	@Override
	public int getStatus() {
		return 200;
	}
}
