package com.thomsonreuters.rest.service;

import com.google.common.base.Supplier;
import com.google.common.base.Suppliers;
import com.google.inject.Inject;
import com.google.inject.Singleton;

import com.netflix.governator.annotations.Configuration;
import com.thomsonreuters.controller.Controller;
import com.thomsonreuters.controller.Controller2;
import com.thomsonreuters.datamodel.AttributeDef;
import com.thomsonreuters.datamodel.EntityAttributeDef;
import com.thomsonreuters.datamodel.EntityDef;
import com.thomsonreuters.datamodel.RelationDef;

import java.io.IOException;
import java.util.List;

import javax.ws.rs.DELETE;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.PUT;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.HttpHeaders;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
@Path("/metacatalogClient")
public class Service2Resource {
	
	private static final Logger logger = LoggerFactory.getLogger("MetaCatalogService");
	
	private static final String defaultMaxResults = "100000000";
	
	@Configuration("1p.service.name")
	private Supplier<String> appName = Suppliers.ofInstance("One Platform");
	
	private final Controller controller;
	private final Controller2 controller2;
	
	@Inject
	public Service2Resource(Controller controller, Controller2 controller2) {
		this.controller = controller;
		this.controller2 = controller2;
	}

	@Path("entities")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response entityList() throws IOException {
		return Response.ok(controller.getEntities("1")).build();
	}

	@Path("summary/{entityId}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response summary(@PathParam("entityId") String entityId) throws IOException {
		return Response.ok(controller2.getEntityDefinitionSummary("1", entityId)).build();
	}

	@Path("fullSummary/{entityId}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response fullSummary(@PathParam("entityId") String entityId) throws IOException {
		return Response.ok(controller2.getEntityDefinitionSummary("1", entityId)).build();
	}

	@Path("newEntity/{entityId}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response newEntity(@PathParam("entityId") String entityId) throws IOException {
		return Response.ok(controller2.newEntity("1", entityId)).build();
	}
	
	@Path("addEntity/{entityId}")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response addEntity(@PathParam("entityId") String entityId, String payload) throws IOException {
		return Response.ok(controller2.addEntity("1", entityId, payload)).build();
	}

}
