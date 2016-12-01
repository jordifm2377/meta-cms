package com.thomsonreuters.rest.service;

import com.fasterxml.jackson.databind.node.JsonNodeFactory;
import com.fasterxml.jackson.databind.node.ObjectNode;

import com.google.inject.Inject;
import com.google.inject.Singleton;

import io.swagger.annotations.Api;
import io.swagger.annotations.ApiOperation;
import io.swagger.annotations.ApiResponse;
import io.swagger.annotations.ApiResponses;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import netflix.karyon.health.HealthCheckHandler;

@Singleton
@Api(value = "/disease/healthcheck")
@Path("/disease/healthcheck")
public class HealthCheckResource {
	
	private static final Logger logger = LoggerFactory.getLogger("DiseaseService");
	
	private final HealthCheckHandler healthCheckHandler;
	
	@Inject
	public HealthCheckResource(HealthCheckHandler healthCheckHandler) {
		this.healthCheckHandler = healthCheckHandler;
	}
	
	@ApiOperation(value = "Health Check", notes = "Returns the result of the Health Check")
	@ApiResponses(value = { @ApiResponse(code = 200, message = "Healthy") })
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response healthcheck() {
		
		ObjectNode response = JsonNodeFactory.instance.objectNode();
		response.put("status", "Disease service is Up & Ready");
		
		logger.info(response.toString());
		
		return Response.status(healthCheckHandler.getStatus()).build();
	}
}
