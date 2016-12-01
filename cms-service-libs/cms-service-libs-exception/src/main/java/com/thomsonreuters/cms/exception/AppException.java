package com.thomsonreuters.cms.exception;

public class AppException extends Exception {
	
	private static final long serialVersionUID = 1L;
	
	// service parameters
	
	public static final String userIdIsNotANumber = "Header parameter User Id is not a number";
	public static final String entityIdIsNotANumber = "Parameter Entity Id is not a number";
	
	public static final String currentParentIdIsNotANumber = "Parameter Current Parent Entity Id is not a number";
	public static final String newParentIdIsNotANumber = "Parameter New Parent Entity Id is not a number";
	
	public static final String userDoesNotExist = "User does not exist";
	
	// tree service
	
	// TODO to be removed once all the different entities are added to this service
	public static final String notAllowed = "This entity is for read-only purposes";
	
	public static final String wrongTerm = "The term does not match any hierarquical entity in the system";
	
	public static final String singleParent = "The entity does not allow multiple parent";
	
	public static final String moveNodeToSameParent = "A node can't be moved inside a parent";
	public static final String newLinkAlreadyExists = "The link already exists: operation aborted";
	
	public static final String addNodeForbidden = "The new parent is a descendant child of this node, add parent relation is forbidden";
	public static final String deleteNodeForbidden = "This node has only one parent, delete parent relation is forbidden";
	
	public static final String linkDoesNotExist = "These two entities are not related";
	public static final String childEntityDoesNotExist = "The child entity does not exist";
	public static final String currentParentEntityDoesNotExist = "The current parent entity does not exist";
	public static final String newParentEntityDoesNotExist = "The new parent entity does not exist";
	
	// common

	public static final String noParameterProvided = "No requirements provided: search operation aborted";
	public static final String noMatches = "No matches";
	
	public static final String entityDoesNotExist = "The entity does not exist";
	
	public static final String noParentProvided = "Missing Entity Parent Id: add operation aborted";
	
	public static final String nothingToUpdate = "The entity has no significant changes: update operation aborted";
	public static final String entityDoesNotExistForUpdate = "The entity does not exist: update operation aborted. Consider adding the entity.";
	
	public static final String isParentEntity = "The entity has children records: delete operation not allowed";
	public static final String entityDoesNotExistForDeleteOperation = "The entity does not exist: delete operation aborted";
	
	// disease service
	
	public static final String nameUK = "Entity names do not allow duplication";
	
	public static final String medDRANotExists = "MedDRA Preferred Term Code does not exist";
	public static final String therapeuticActivityNotExists = "Therapeutic Activity Id does not exist";
	public static final String synonymUK = "Synonyms do not allow duplication";
	
	@SuppressWarnings("unused")
	private AppException() {
		// private default constructor
	}
	
	public AppException(String message) {
		
		super(message);
	}
}
