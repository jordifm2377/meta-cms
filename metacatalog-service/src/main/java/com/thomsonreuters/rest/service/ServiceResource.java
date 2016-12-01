package com.thomsonreuters.rest.service;

import com.google.common.base.Supplier;
import com.google.common.base.Suppliers;
import com.google.inject.Inject;
import com.google.inject.Singleton;

import com.netflix.governator.annotations.Configuration;
import com.thomsonreuters.controller.Controller;
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
@Path("/metacatalog")
public class ServiceResource {
	
	private static final Logger logger = LoggerFactory.getLogger("MetaCatalogService");
	
	private static final String defaultMaxResults = "100000000";
	
	@Configuration("1p.service.name")
	private Supplier<String> appName = Suppliers.ofInstance("One Platform");
	
	private final Controller controller;
	
	@Inject
	public ServiceResource(Controller controller) {
		this.controller = controller;
	}
	
	@Path("search")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response search(@QueryParam("name") String searchTerm, 
			@QueryParam("maxResults") @DefaultValue(value = defaultMaxResults) String maxResults) throws IOException {
		return null;
	}
	/*
	@Path("{id}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response retrieve(@PathParam("id") String id) throws IOException {
		return null;
	}
	*/
	
	@Path("getAttr/{attrId}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getAttribute(@Context HttpHeaders headers, @PathParam("attrId") String attrId) throws IOException {
		AttributeDef response = controller.getAttribute("1", attrId);
		return Response.ok(response).build();
	}

	@Path("getAttribs")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getAttributes(@Context HttpHeaders headers) throws IOException {
		List<AttributeDef> response = controller.getAttributes("1");
		return Response.ok(response).build();
	}

	@Path("addAttr")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response addAttribute(@Context HttpHeaders headers, String attrContent) throws IOException {
		long response = controller.addAttribute("1", attrContent);
		return Response.ok(response).build();
	}

	@Path("updateAttr")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response updateAttribute(@Context HttpHeaders headers, String attrContent) throws IOException {
		long response = controller.updateAttribute("1", attrContent);
		return Response.ok(response).build();
	}

	@Path("deleteAttr/{attrId}")
	@DELETE
	@Produces(MediaType.APPLICATION_JSON)
	public Response deleteAttribute(@Context HttpHeaders headers, @PathParam("attrId") String attrId) throws IOException {
		long response = controller.deleteAttribute("1", attrId);
		return Response.ok(response).build();
	}

	@Path("enableAttr/{attrId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response enableAttribute(@Context HttpHeaders headers, @PathParam("attrId") String attrId) throws IOException {
		long response = controller.enableAttribute("1", attrId);
		return Response.ok(response).build();
	}

	@Path("disableAttr/{attrId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response disableAttribute(@Context HttpHeaders headers, @PathParam("attrId") String attrId) throws IOException {
		long response = controller.disableAttribute("1", attrId);
		return Response.ok(response).build();
	}

	
	

	@Path("getEntity/{entityId}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getEntity(@Context HttpHeaders headers, @PathParam("entityId") String entityId) throws IOException {
		EntityDef response = controller.getEntity("1", entityId);
		return Response.ok(response).build();
	}

	@Path("getEntities")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getEntities(@Context HttpHeaders headers) throws IOException {
		List<EntityDef> response = controller.getEntities("1");
		return Response.ok(response).build();
	}

	@Path("addEntity")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response addEntity(@Context HttpHeaders headers, String entityContent) throws IOException {
		long response = controller.addEntity("1", entityContent);
		return Response.ok(response).build();
	}

	@Path("updateEntity")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response updateEntity(@Context HttpHeaders headers, String entityContent) throws IOException {
		long response = controller.updateEntity("1", entityContent);
		return Response.ok(response).build();
	}

	@Path("deleteEntity/{entityId}")
	@DELETE
	@Produces(MediaType.APPLICATION_JSON)
	public Response deleteEntity(@Context HttpHeaders headers, @PathParam("entityId") String entityId) throws IOException {
		long response = controller.deleteEntity("1", entityId);
		return Response.ok(response).build();
	}

	@Path("enableEntity/{entityId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response enableEntity(@Context HttpHeaders headers, @PathParam("entityId") String entityId) throws IOException {
		long response = controller.enableEntity("1", entityId);
		return Response.ok(response).build();
	}

	@Path("disableEntity/{entityId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response disableEntity(@Context HttpHeaders headers, @PathParam("entityId") String entityId) throws IOException {
		long response = controller.disableEntity("1", entityId);
		return Response.ok(response).build();
	}



	@Path("getEntityAttr/{entityAttrId}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getEntityAttribute(@Context HttpHeaders headers, @PathParam("entityAttrId") String entityAttrId) throws IOException {
		EntityAttributeDef response = controller.getEntityAttribute("1", entityAttrId);
		return Response.ok(response).build();
	}

	@Path("getEntitesAttributes")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getEntitesAttributes(@Context HttpHeaders headers) throws IOException {
		List<EntityAttributeDef> response = controller.getEntitiesAttributes("1");
		return Response.ok(response).build();
	}

	@Path("addEntityAttribute")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response addEntityAttribute(@Context HttpHeaders headers, String entityAttrContent) throws IOException {
		long response = controller.addEntityAttribute("1", entityAttrContent);
		return Response.ok(response).build();
	}

	@Path("updateEntityAttribute")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response updateEntityAttribute(@Context HttpHeaders headers, String entityAttrContent) throws IOException {
		long response = controller.updateEntityAttribute("1", entityAttrContent);
		return Response.ok(response).build();
	}

	@Path("deleteEntityAttribute/{entityId}")
	@DELETE
	@Produces(MediaType.APPLICATION_JSON)
	public Response deleteEntityAttribute(@Context HttpHeaders headers, @PathParam("entityAttrId") String entityAttrId) throws IOException {
		long response = controller.deleteEntityAttribute("1", entityAttrId);
		return Response.ok(response).build();
	}

	@Path("enableEntityAttribute/{entityId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response enableEntityAttribute(@Context HttpHeaders headers, @PathParam("entityAttrId") String entityAttrId) throws IOException {
		long response = controller.enableEntityAttribute("1", entityAttrId);
		return Response.ok(response).build();
	}

	@Path("disableEntityAttribute/{entityId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response disableEntityAttribute(@Context HttpHeaders headers, @PathParam("entityAttrId") String entityAttrId) throws IOException {
		long response = controller.disableEntityAttribute("1", entityAttrId);
		return Response.ok(response).build();
	}
	

	@Path("getRelation/{relationId}")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getRelation(@Context HttpHeaders headers, @PathParam("relationId") String relationId) throws IOException {
		RelationDef response = controller.getRelation("1", relationId);
		return Response.ok(response).build();
	}

	@Path("getRelations")
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public Response getRelations(@Context HttpHeaders headers) throws IOException {
		List<RelationDef> response = controller.getRelations("1");
		return Response.ok(response).build();
	}

	@Path("addRelation")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response addRelation(@Context HttpHeaders headers, String relationContent) throws IOException {
		long response = controller.addRelation("1", relationContent);
		return Response.ok(response).build();
	}

	@Path("updateRelation")
	@POST
	@Produces(MediaType.APPLICATION_JSON)
	public Response updateRelation(@Context HttpHeaders headers, String relationContent) throws IOException {
		long response = controller.updateRelation("1", relationContent);
		return Response.ok(response).build();
	}

	@Path("deleteRelation/{relationId}")
	@DELETE
	@Produces(MediaType.APPLICATION_JSON)
	public Response deleteRelation(@Context HttpHeaders headers, @PathParam("relationId") String relationId) throws IOException {
		long response = controller.deleteRelation("1", relationId);
		return Response.ok(response).build();
	}

	@Path("enableRelation/{relationId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response enableRelation(@Context HttpHeaders headers, @PathParam("relationId") String relationId) throws IOException {
		long response = controller.enableRelation("1", relationId);
		return Response.ok(response).build();
	}

	@Path("disableRelation/{relationId}")
	@PUT
	@Produces(MediaType.APPLICATION_JSON)
	public Response disableRelation(@Context HttpHeaders headers, @PathParam("relationId") String relationId) throws IOException {
		long response = controller.disableRelation("1", relationId);
		return Response.ok(response).build();
	}

}
