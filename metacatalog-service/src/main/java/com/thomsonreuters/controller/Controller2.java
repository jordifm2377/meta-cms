package com.thomsonreuters.controller;

import com.thomsonreuters.datamodel.client.EntityDefClient;

public interface Controller2 {
	
	public EntityDefClient getEntityDefinitionSummary(String userId, long entityId, int deep);
	public EntityDefClient getEntityDefinitionSummary(String userId, String entityName);
	public EntityDefClient newEntity(String userId, String entityId);
	public EntityDefClient addEntity(String userId, String entityId, String payload);
}
