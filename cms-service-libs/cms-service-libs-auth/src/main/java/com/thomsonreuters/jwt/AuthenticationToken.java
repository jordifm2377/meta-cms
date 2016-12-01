package com.thomsonreuters.jwt;

import java.util.Map;

import com.thomsonreuters.exception.TokenExpiredException;

public interface AuthenticationToken {

	public String generateToken(Map<String, Object> claims);
	
	/**
	 * 
	 * @param token tp extract header from
	 * @return token header, Base64url, not encrypted
	 */
	public String getHeader(String token) throws IllegalArgumentException;

	/**
	 * 
	 * @param token - to extract payload from
	 * @return token payload, Base64url, might be encrypted
	 */
	public String getPayload(String token) throws IllegalArgumentException;

	/**
	 * 
	 * @param token - token to extract signature from
	 * @return token signature, base64url, algorithm available in the header
	 */
	public String getSignature(String token)  throws IllegalArgumentException;
  
	/**
	 * Verifies token data
	 * @param token - token to validate
	 * @return map of claims
	 */
	public Map<String, Object> verifyToken(String token) throws TokenExpiredException;
}
