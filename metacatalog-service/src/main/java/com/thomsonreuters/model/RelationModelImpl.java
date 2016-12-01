package com.thomsonreuters.model;

import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.db.ResultObject;
import com.thomsonreuters.cms.db.RowObject;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.RelationDef;
import com.thomsonreuters.query.Query;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class RelationModelImpl implements RelationModel {
	
	private static final Logger logger = LoggerFactory.getLogger("RelationModelImpl");

	@Override
	public List<Long> search(String userId, String searchTerm, DatabaseExecutor databaseExecutor) throws SQLException {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public RelationDef getRelation(String userId, long relationId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {
        
		if(relationId <= 0)
			return null;
		String query = Query.GET_RELATION;
        Object[] parameters = new Object[]{relationId};

        ResultObject res = databaseExecutor.retrieveQuery(query, parameters);

        if(res.getRows().size() <= 0) {
        	throw new AppErrorException(AppErrorException.missingTerm);
        }
        logger.debug("Get relation Id {}", relationId);
        return parseRelationRow(res.getRows().get(0));

	}

	@Override
	public List<RelationDef> getRelationList(String userId, DatabaseExecutor databaseExecutor) 
		throws AppErrorException, AppException, SQLException {
		
		String query = Query.GET_RELATIONS;

        ResultObject res = databaseExecutor.retrieveQuery(query, new Object[]{});
        if(res.getRows().size() <= 0) {
        	return new ArrayList<>();
        }
        List<RelationDef> relDefList = new ArrayList<>();
        res.getRows().forEach( row -> relDefList.add(parseRelationRow(row)));
        logger.debug("Get relations");
        
        return relDefList;
	}

	@Override
	public long insertRelation(String userId, RelationDef relationDef, DatabaseExecutor databaseExecutor)
			 throws AppErrorException, AppException, SQLException {

        String query = Query.INSERT_RELATION;
        Object[] parameters = new Object[]{relationDef.getName(), relationDef.getCaption(), relationDef.getDescription()
        		, relationDef.getParentId(), relationDef.getChildId(), relationDef.getOrderType(), relationDef.getTag()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }

        logger.debug("Adding relation Id {}", relationDef.getId());
		return 0;
	}


	@Override
	public long updateRelation(String userId, RelationDef relationDef, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
		
        String query = Query.UPDATE_RELATION;
        Object[] parameters = new Object[]{relationDef.getName(), relationDef.getCaption(), relationDef.getDescription()
        		, relationDef.getParentId(), relationDef.getChildId(), relationDef.getOrderType(), relationDef.getTag()
        		, relationDef.getId()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }

        logger.debug("Updating attribute Id {}", relationDef.getId());
		return 0;
	}

	@Override
	public long deleteRelation(String userId, long relationId, DatabaseExecutor databaseExecutor) 
			throws AppErrorException, AppException, SQLException {
		
        String query = Query.DELETE_RELATION;
        Object[] parameters = new Object[]{relationId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.delete);
        }

        logger.debug("Deleting attribute Id {}", relationId);

		return 0;
	}

	@Override
	public long enableRelation(String userId, long relationId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ENTITY_STATUS;
        Object[] parameters = new Object[]{"Y", relationId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }

        logger.debug("Enabling attribute Id {}", relationId);

		return 0;
	}

	@Override
	public long disableRelation(String userId, long relationId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ENTITY_STATUS;
        Object[] parameters = new Object[]{"N", relationId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }

        logger.debug("Disabling attribute Id {}", relationId);

		return 0;
	}

	private RelationDef parseRelationRow(RowObject row) {
		RelationDef relationDef = new RelationDef();
		relationDef.setId((Integer) row.getRowValue().get("id"));
		relationDef.setName((String)row.getRowValue().get("name"));
		relationDef.setCaption((String)row.getRowValue().getOrDefault("caption", ""));
		relationDef.setDescription((String)row.getRowValue().getOrDefault("description", ""));
		relationDef.setOrderType((String)row.getRowValue().get("order_type"));
		relationDef.setParentId((Integer)row.getRowValue().getOrDefault("parent_entity_id", 0));
		relationDef.setChildId((Integer)row.getRowValue().getOrDefault("child_entity_id", 0));
		relationDef.setTag((String)row.getRowValue().getOrDefault("tag", ""));
		relationDef.setEnabled((String)row.getRowValue().getOrDefault("enabled", "N"));
		return relationDef;
	}

}
