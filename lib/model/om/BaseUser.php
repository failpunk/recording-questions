<?php

/**
 * Base class that represents a row from the 'user' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseUser extends BaseObject  implements Persistent {


  const PEER = 'UserPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        UserPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;

	/**
	 * The value for the display_name field.
	 * @var        string
	 */
	protected $display_name;

	/**
	 * The value for the real_name field.
	 * @var        string
	 */
	protected $real_name;

	/**
	 * The value for the location field.
	 * @var        string
	 */
	protected $location;

	/**
	 * The value for the webpage field.
	 * @var        string
	 */
	protected $webpage;

	/**
	 * The value for the country field.
	 * @var        string
	 */
	protected $country;

	/**
	 * The value for the postal_code field.
	 * @var        int
	 */
	protected $postal_code;

	/**
	 * The value for the birthday field.
	 * @var        string
	 */
	protected $birthday;

	/**
	 * The value for the gravatar_address field.
	 * @var        string
	 */
	protected $gravatar_address;

	/**
	 * The value for the info field.
	 * @var        string
	 */
	protected $info;

	/**
	 * The value for the platform field.
	 * Note: this column has a database default value of: 'pc'
	 * @var        string
	 */
	protected $platform;

	/**
	 * The value for the experience_score field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $experience_score;

	/**
	 * The value for the up_votes field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $up_votes;

	/**
	 * The value for the down_votes field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $down_votes;

	/**
	 * The value for the is_guest field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $is_guest;

	/**
	 * The value for the is_admin field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $is_admin;

	/**
	 * The value for the today_votes field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $today_votes;

	/**
	 * The value for the email_on field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $email_on;

	/**
	 * The value for the last_email field.
	 * @var        string
	 */
	protected $last_email;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * @var        array UserExperience[] Collection to store aggregation of UserExperience objects.
	 */
	protected $collUserExperiences;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserExperiences.
	 */
	private $lastUserExperienceCriteria = null;

	/**
	 * @var        array Openid[] Collection to store aggregation of Openid objects.
	 */
	protected $collOpenids;

	/**
	 * @var        Criteria The criteria used to select the current contents of collOpenids.
	 */
	private $lastOpenidCriteria = null;

	/**
	 * @var        array rpxAuth[] Collection to store aggregation of rpxAuth objects.
	 */
	protected $collrpxAuths;

	/**
	 * @var        Criteria The criteria used to select the current contents of collrpxAuths.
	 */
	private $lastrpxAuthCriteria = null;

	/**
	 * @var        array Question[] Collection to store aggregation of Question objects.
	 */
	protected $collQuestions;

	/**
	 * @var        Criteria The criteria used to select the current contents of collQuestions.
	 */
	private $lastQuestionCriteria = null;

	/**
	 * @var        array QuestionComment[] Collection to store aggregation of QuestionComment objects.
	 */
	protected $collQuestionComments;

	/**
	 * @var        Criteria The criteria used to select the current contents of collQuestionComments.
	 */
	private $lastQuestionCommentCriteria = null;

	/**
	 * @var        array Answer[] Collection to store aggregation of Answer objects.
	 */
	protected $collAnswers;

	/**
	 * @var        Criteria The criteria used to select the current contents of collAnswers.
	 */
	private $lastAnswerCriteria = null;

	/**
	 * @var        array AnswerComment[] Collection to store aggregation of AnswerComment objects.
	 */
	protected $collAnswerComments;

	/**
	 * @var        Criteria The criteria used to select the current contents of collAnswerComments.
	 */
	private $lastAnswerCommentCriteria = null;

	/**
	 * @var        array QuestionVote[] Collection to store aggregation of QuestionVote objects.
	 */
	protected $collQuestionVotes;

	/**
	 * @var        Criteria The criteria used to select the current contents of collQuestionVotes.
	 */
	private $lastQuestionVoteCriteria = null;

	/**
	 * @var        array AnswerVote[] Collection to store aggregation of AnswerVote objects.
	 */
	protected $collAnswerVotes;

	/**
	 * @var        Criteria The criteria used to select the current contents of collAnswerVotes.
	 */
	private $lastAnswerVoteCriteria = null;

	/**
	 * @var        array UserFavorite[] Collection to store aggregation of UserFavorite objects.
	 */
	protected $collUserFavorites;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserFavorites.
	 */
	private $lastUserFavoriteCriteria = null;

	/**
	 * @var        array UserTag[] Collection to store aggregation of UserTag objects.
	 */
	protected $collUserTags;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserTags.
	 */
	private $lastUserTagCriteria = null;

	/**
	 * @var        array CheckInformation[] Collection to store aggregation of CheckInformation objects.
	 */
	protected $collCheckInformations;

	/**
	 * @var        Criteria The criteria used to select the current contents of collCheckInformations.
	 */
	private $lastCheckInformationCriteria = null;

	/**
	 * @var        array AnswerOffensive[] Collection to store aggregation of AnswerOffensive objects.
	 */
	protected $collAnswerOffensives;

	/**
	 * @var        Criteria The criteria used to select the current contents of collAnswerOffensives.
	 */
	private $lastAnswerOffensiveCriteria = null;

	/**
	 * @var        array QuestionOffensive[] Collection to store aggregation of QuestionOffensive objects.
	 */
	protected $collQuestionOffensives;

	/**
	 * @var        Criteria The criteria used to select the current contents of collQuestionOffensives.
	 */
	private $lastQuestionOffensiveCriteria = null;

	/**
	 * @var        array UserAward[] Collection to store aggregation of UserAward objects.
	 */
	protected $collUserAwards;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserAwards.
	 */
	private $lastUserAwardCriteria = null;

	/**
	 * @var        array MemberReferral[] Collection to store aggregation of MemberReferral objects.
	 */
	protected $collMemberReferrals;

	/**
	 * @var        Criteria The criteria used to select the current contents of collMemberReferrals.
	 */
	private $lastMemberReferralCriteria = null;

	/**
	 * @var        array GearCompanyInfo[] Collection to store aggregation of GearCompanyInfo objects.
	 */
	protected $collGearCompanyInfos;

	/**
	 * @var        Criteria The criteria used to select the current contents of collGearCompanyInfos.
	 */
	private $lastGearCompanyInfoCriteria = null;

	/**
	 * @var        array GearInfo[] Collection to store aggregation of GearInfo objects.
	 */
	protected $collGearInfos;

	/**
	 * @var        Criteria The criteria used to select the current contents of collGearInfos.
	 */
	private $lastGearInfoCriteria = null;

	/**
	 * @var        array GearReview[] Collection to store aggregation of GearReview objects.
	 */
	protected $collGearReviews;

	/**
	 * @var        Criteria The criteria used to select the current contents of collGearReviews.
	 */
	private $lastGearReviewCriteria = null;

	/**
	 * @var        array UserGear[] Collection to store aggregation of UserGear objects.
	 */
	protected $collUserGears;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserGears.
	 */
	private $lastUserGearCriteria = null;

	/**
	 * @var        array Offensive[] Collection to store aggregation of Offensive objects.
	 */
	protected $collOffensives;

	/**
	 * @var        Criteria The criteria used to select the current contents of collOffensives.
	 */
	private $lastOffensiveCriteria = null;

	/**
	 * @var        array RecentActivity[] Collection to store aggregation of RecentActivity objects.
	 */
	protected $collRecentActivitys;

	/**
	 * @var        Criteria The criteria used to select the current contents of collRecentActivitys.
	 */
	private $lastRecentActivityCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Initializes internal state of BaseUser object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->platform = 'pc';
		$this->experience_score = 0;
		$this->up_votes = 0;
		$this->down_votes = 0;
		$this->is_guest = 0;
		$this->is_admin = 0;
		$this->today_votes = 0;
		$this->email_on = 1;
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [email] column value.
	 * 
	 * @return     string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Get the [display_name] column value.
	 * 
	 * @return     string
	 */
	public function getDisplayName()
	{
		return $this->display_name;
	}

	/**
	 * Get the [real_name] column value.
	 * 
	 * @return     string
	 */
	public function getRealName()
	{
		return $this->real_name;
	}

	/**
	 * Get the [location] column value.
	 * 
	 * @return     string
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * Get the [webpage] column value.
	 * 
	 * @return     string
	 */
	public function getWebpage()
	{
		return $this->webpage;
	}

	/**
	 * Get the [country] column value.
	 * 
	 * @return     string
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * Get the [postal_code] column value.
	 * 
	 * @return     int
	 */
	public function getPostalCode()
	{
		return $this->postal_code;
	}

	/**
	 * Get the [optionally formatted] temporal [birthday] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getBirthday($format = 'Y-m-d H:i:s')
	{
		if ($this->birthday === null) {
			return null;
		}


		if ($this->birthday === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->birthday);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->birthday, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [gravatar_address] column value.
	 * 
	 * @return     string
	 */
	public function getGravatarAddress()
	{
		return $this->gravatar_address;
	}

	/**
	 * Get the [info] column value.
	 * 
	 * @return     string
	 */
	public function getInfo()
	{
		return $this->info;
	}

	/**
	 * Get the [platform] column value.
	 * 
	 * @return     string
	 */
	public function getPlatform()
	{
		return $this->platform;
	}

	/**
	 * Get the [experience_score] column value.
	 * 
	 * @return     int
	 */
	public function getExperienceScore()
	{
		return $this->experience_score;
	}

	/**
	 * Get the [up_votes] column value.
	 * 
	 * @return     int
	 */
	public function getUpVotes()
	{
		return $this->up_votes;
	}

	/**
	 * Get the [down_votes] column value.
	 * 
	 * @return     int
	 */
	public function getDownVotes()
	{
		return $this->down_votes;
	}

	/**
	 * Get the [is_guest] column value.
	 * 
	 * @return     int
	 */
	public function getIsGuest()
	{
		return $this->is_guest;
	}

	/**
	 * Get the [is_admin] column value.
	 * 
	 * @return     int
	 */
	public function getIsAdmin()
	{
		return $this->is_admin;
	}

	/**
	 * Get the [today_votes] column value.
	 * 
	 * @return     int
	 */
	public function getTodayVotes()
	{
		return $this->today_votes;
	}

	/**
	 * Get the [email_on] column value.
	 * 
	 * @return     int
	 */
	public function getEmailOn()
	{
		return $this->email_on;
	}

	/**
	 * Get the [optionally formatted] temporal [last_email] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getLastEmail($format = 'Y-m-d H:i:s')
	{
		if ($this->last_email === null) {
			return null;
		}


		if ($this->last_email === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->last_email);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_email, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = UserPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setEmail($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = UserPeer::EMAIL;
		}

		return $this;
	} // setEmail()

	/**
	 * Set the value of [display_name] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setDisplayName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->display_name !== $v) {
			$this->display_name = $v;
			$this->modifiedColumns[] = UserPeer::DISPLAY_NAME;
		}

		return $this;
	} // setDisplayName()

	/**
	 * Set the value of [real_name] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setRealName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->real_name !== $v) {
			$this->real_name = $v;
			$this->modifiedColumns[] = UserPeer::REAL_NAME;
		}

		return $this;
	} // setRealName()

	/**
	 * Set the value of [location] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setLocation($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->location !== $v) {
			$this->location = $v;
			$this->modifiedColumns[] = UserPeer::LOCATION;
		}

		return $this;
	} // setLocation()

	/**
	 * Set the value of [webpage] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setWebpage($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->webpage !== $v) {
			$this->webpage = $v;
			$this->modifiedColumns[] = UserPeer::WEBPAGE;
		}

		return $this;
	} // setWebpage()

	/**
	 * Set the value of [country] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setCountry($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->country !== $v) {
			$this->country = $v;
			$this->modifiedColumns[] = UserPeer::COUNTRY;
		}

		return $this;
	} // setCountry()

	/**
	 * Set the value of [postal_code] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setPostalCode($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->postal_code !== $v) {
			$this->postal_code = $v;
			$this->modifiedColumns[] = UserPeer::POSTAL_CODE;
		}

		return $this;
	} // setPostalCode()

	/**
	 * Sets the value of [birthday] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     User The current object (for fluent API support)
	 */
	public function setBirthday($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->birthday !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->birthday !== null && $tmpDt = new DateTime($this->birthday)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->birthday = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = UserPeer::BIRTHDAY;
			}
		} // if either are not null

		return $this;
	} // setBirthday()

	/**
	 * Set the value of [gravatar_address] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setGravatarAddress($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->gravatar_address !== $v) {
			$this->gravatar_address = $v;
			$this->modifiedColumns[] = UserPeer::GRAVATAR_ADDRESS;
		}

		return $this;
	} // setGravatarAddress()

	/**
	 * Set the value of [info] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setInfo($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->info !== $v) {
			$this->info = $v;
			$this->modifiedColumns[] = UserPeer::INFO;
		}

		return $this;
	} // setInfo()

	/**
	 * Set the value of [platform] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setPlatform($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->platform !== $v || $v === 'pc') {
			$this->platform = $v;
			$this->modifiedColumns[] = UserPeer::PLATFORM;
		}

		return $this;
	} // setPlatform()

	/**
	 * Set the value of [experience_score] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setExperienceScore($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->experience_score !== $v || $v === 0) {
			$this->experience_score = $v;
			$this->modifiedColumns[] = UserPeer::EXPERIENCE_SCORE;
		}

		return $this;
	} // setExperienceScore()

	/**
	 * Set the value of [up_votes] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setUpVotes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->up_votes !== $v || $v === 0) {
			$this->up_votes = $v;
			$this->modifiedColumns[] = UserPeer::UP_VOTES;
		}

		return $this;
	} // setUpVotes()

	/**
	 * Set the value of [down_votes] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setDownVotes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->down_votes !== $v || $v === 0) {
			$this->down_votes = $v;
			$this->modifiedColumns[] = UserPeer::DOWN_VOTES;
		}

		return $this;
	} // setDownVotes()

	/**
	 * Set the value of [is_guest] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setIsGuest($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->is_guest !== $v || $v === 0) {
			$this->is_guest = $v;
			$this->modifiedColumns[] = UserPeer::IS_GUEST;
		}

		return $this;
	} // setIsGuest()

	/**
	 * Set the value of [is_admin] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setIsAdmin($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->is_admin !== $v || $v === 0) {
			$this->is_admin = $v;
			$this->modifiedColumns[] = UserPeer::IS_ADMIN;
		}

		return $this;
	} // setIsAdmin()

	/**
	 * Set the value of [today_votes] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setTodayVotes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->today_votes !== $v || $v === 0) {
			$this->today_votes = $v;
			$this->modifiedColumns[] = UserPeer::TODAY_VOTES;
		}

		return $this;
	} // setTodayVotes()

	/**
	 * Set the value of [email_on] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setEmailOn($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->email_on !== $v || $v === 1) {
			$this->email_on = $v;
			$this->modifiedColumns[] = UserPeer::EMAIL_ON;
		}

		return $this;
	} // setEmailOn()

	/**
	 * Sets the value of [last_email] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     User The current object (for fluent API support)
	 */
	public function setLastEmail($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->last_email !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->last_email !== null && $tmpDt = new DateTime($this->last_email)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->last_email = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = UserPeer::LAST_EMAIL;
			}
		} // if either are not null

		return $this;
	} // setLastEmail()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     User The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = UserPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     User The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = UserPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array(UserPeer::PLATFORM,UserPeer::EXPERIENCE_SCORE,UserPeer::UP_VOTES,UserPeer::DOWN_VOTES,UserPeer::IS_GUEST,UserPeer::IS_ADMIN,UserPeer::TODAY_VOTES,UserPeer::EMAIL_ON))) {
				return false;
			}

			if ($this->platform !== 'pc') {
				return false;
			}

			if ($this->experience_score !== 0) {
				return false;
			}

			if ($this->up_votes !== 0) {
				return false;
			}

			if ($this->down_votes !== 0) {
				return false;
			}

			if ($this->is_guest !== 0) {
				return false;
			}

			if ($this->is_admin !== 0) {
				return false;
			}

			if ($this->today_votes !== 0) {
				return false;
			}

			if ($this->email_on !== 1) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->email = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->display_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->real_name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->location = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->webpage = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->country = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->postal_code = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->birthday = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->gravatar_address = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->info = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->platform = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->experience_score = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
			$this->up_votes = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
			$this->down_votes = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
			$this->is_guest = ($row[$startcol + 15] !== null) ? (int) $row[$startcol + 15] : null;
			$this->is_admin = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
			$this->today_votes = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
			$this->email_on = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
			$this->last_email = ($row[$startcol + 19] !== null) ? (string) $row[$startcol + 19] : null;
			$this->created_at = ($row[$startcol + 20] !== null) ? (string) $row[$startcol + 20] : null;
			$this->updated_at = ($row[$startcol + 21] !== null) ? (string) $row[$startcol + 21] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 22; // 22 = UserPeer::NUM_COLUMNS - UserPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collUserExperiences = null;
			$this->lastUserExperienceCriteria = null;

			$this->collOpenids = null;
			$this->lastOpenidCriteria = null;

			$this->collrpxAuths = null;
			$this->lastrpxAuthCriteria = null;

			$this->collQuestions = null;
			$this->lastQuestionCriteria = null;

			$this->collQuestionComments = null;
			$this->lastQuestionCommentCriteria = null;

			$this->collAnswers = null;
			$this->lastAnswerCriteria = null;

			$this->collAnswerComments = null;
			$this->lastAnswerCommentCriteria = null;

			$this->collQuestionVotes = null;
			$this->lastQuestionVoteCriteria = null;

			$this->collAnswerVotes = null;
			$this->lastAnswerVoteCriteria = null;

			$this->collUserFavorites = null;
			$this->lastUserFavoriteCriteria = null;

			$this->collUserTags = null;
			$this->lastUserTagCriteria = null;

			$this->collCheckInformations = null;
			$this->lastCheckInformationCriteria = null;

			$this->collAnswerOffensives = null;
			$this->lastAnswerOffensiveCriteria = null;

			$this->collQuestionOffensives = null;
			$this->lastQuestionOffensiveCriteria = null;

			$this->collUserAwards = null;
			$this->lastUserAwardCriteria = null;

			$this->collMemberReferrals = null;
			$this->lastMemberReferralCriteria = null;

			$this->collGearCompanyInfos = null;
			$this->lastGearCompanyInfoCriteria = null;

			$this->collGearInfos = null;
			$this->lastGearInfoCriteria = null;

			$this->collGearReviews = null;
			$this->lastGearReviewCriteria = null;

			$this->collUserGears = null;
			$this->lastUserGearCriteria = null;

			$this->collOffensives = null;
			$this->lastOffensiveCriteria = null;

			$this->collRecentActivitys = null;
			$this->lastRecentActivityCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseUser:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			UserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseUser:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseUser:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(UserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(UserPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseUser:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			UserPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			if ($this->isNew() ) {
				$this->modifiedColumns[] = UserPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = UserPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += UserPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collUserExperiences !== null) {
				foreach ($this->collUserExperiences as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOpenids !== null) {
				foreach ($this->collOpenids as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collrpxAuths !== null) {
				foreach ($this->collrpxAuths as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collQuestions !== null) {
				foreach ($this->collQuestions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collQuestionComments !== null) {
				foreach ($this->collQuestionComments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAnswers !== null) {
				foreach ($this->collAnswers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAnswerComments !== null) {
				foreach ($this->collAnswerComments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collQuestionVotes !== null) {
				foreach ($this->collQuestionVotes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAnswerVotes !== null) {
				foreach ($this->collAnswerVotes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserFavorites !== null) {
				foreach ($this->collUserFavorites as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserTags !== null) {
				foreach ($this->collUserTags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCheckInformations !== null) {
				foreach ($this->collCheckInformations as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAnswerOffensives !== null) {
				foreach ($this->collAnswerOffensives as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collQuestionOffensives !== null) {
				foreach ($this->collQuestionOffensives as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserAwards !== null) {
				foreach ($this->collUserAwards as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMemberReferrals !== null) {
				foreach ($this->collMemberReferrals as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGearCompanyInfos !== null) {
				foreach ($this->collGearCompanyInfos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGearInfos !== null) {
				foreach ($this->collGearInfos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGearReviews !== null) {
				foreach ($this->collGearReviews as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserGears !== null) {
				foreach ($this->collUserGears as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOffensives !== null) {
				foreach ($this->collOffensives as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRecentActivitys !== null) {
				foreach ($this->collRecentActivitys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserExperiences !== null) {
					foreach ($this->collUserExperiences as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOpenids !== null) {
					foreach ($this->collOpenids as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collrpxAuths !== null) {
					foreach ($this->collrpxAuths as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collQuestions !== null) {
					foreach ($this->collQuestions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collQuestionComments !== null) {
					foreach ($this->collQuestionComments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAnswers !== null) {
					foreach ($this->collAnswers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAnswerComments !== null) {
					foreach ($this->collAnswerComments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collQuestionVotes !== null) {
					foreach ($this->collQuestionVotes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAnswerVotes !== null) {
					foreach ($this->collAnswerVotes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserFavorites !== null) {
					foreach ($this->collUserFavorites as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserTags !== null) {
					foreach ($this->collUserTags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCheckInformations !== null) {
					foreach ($this->collCheckInformations as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAnswerOffensives !== null) {
					foreach ($this->collAnswerOffensives as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collQuestionOffensives !== null) {
					foreach ($this->collQuestionOffensives as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserAwards !== null) {
					foreach ($this->collUserAwards as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMemberReferrals !== null) {
					foreach ($this->collMemberReferrals as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGearCompanyInfos !== null) {
					foreach ($this->collGearCompanyInfos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGearInfos !== null) {
					foreach ($this->collGearInfos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGearReviews !== null) {
					foreach ($this->collGearReviews as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserGears !== null) {
					foreach ($this->collUserGears as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOffensives !== null) {
					foreach ($this->collOffensives as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRecentActivitys !== null) {
					foreach ($this->collRecentActivitys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getEmail();
				break;
			case 2:
				return $this->getDisplayName();
				break;
			case 3:
				return $this->getRealName();
				break;
			case 4:
				return $this->getLocation();
				break;
			case 5:
				return $this->getWebpage();
				break;
			case 6:
				return $this->getCountry();
				break;
			case 7:
				return $this->getPostalCode();
				break;
			case 8:
				return $this->getBirthday();
				break;
			case 9:
				return $this->getGravatarAddress();
				break;
			case 10:
				return $this->getInfo();
				break;
			case 11:
				return $this->getPlatform();
				break;
			case 12:
				return $this->getExperienceScore();
				break;
			case 13:
				return $this->getUpVotes();
				break;
			case 14:
				return $this->getDownVotes();
				break;
			case 15:
				return $this->getIsGuest();
				break;
			case 16:
				return $this->getIsAdmin();
				break;
			case 17:
				return $this->getTodayVotes();
				break;
			case 18:
				return $this->getEmailOn();
				break;
			case 19:
				return $this->getLastEmail();
				break;
			case 20:
				return $this->getCreatedAt();
				break;
			case 21:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getEmail(),
			$keys[2] => $this->getDisplayName(),
			$keys[3] => $this->getRealName(),
			$keys[4] => $this->getLocation(),
			$keys[5] => $this->getWebpage(),
			$keys[6] => $this->getCountry(),
			$keys[7] => $this->getPostalCode(),
			$keys[8] => $this->getBirthday(),
			$keys[9] => $this->getGravatarAddress(),
			$keys[10] => $this->getInfo(),
			$keys[11] => $this->getPlatform(),
			$keys[12] => $this->getExperienceScore(),
			$keys[13] => $this->getUpVotes(),
			$keys[14] => $this->getDownVotes(),
			$keys[15] => $this->getIsGuest(),
			$keys[16] => $this->getIsAdmin(),
			$keys[17] => $this->getTodayVotes(),
			$keys[18] => $this->getEmailOn(),
			$keys[19] => $this->getLastEmail(),
			$keys[20] => $this->getCreatedAt(),
			$keys[21] => $this->getUpdatedAt(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setEmail($value);
				break;
			case 2:
				$this->setDisplayName($value);
				break;
			case 3:
				$this->setRealName($value);
				break;
			case 4:
				$this->setLocation($value);
				break;
			case 5:
				$this->setWebpage($value);
				break;
			case 6:
				$this->setCountry($value);
				break;
			case 7:
				$this->setPostalCode($value);
				break;
			case 8:
				$this->setBirthday($value);
				break;
			case 9:
				$this->setGravatarAddress($value);
				break;
			case 10:
				$this->setInfo($value);
				break;
			case 11:
				$this->setPlatform($value);
				break;
			case 12:
				$this->setExperienceScore($value);
				break;
			case 13:
				$this->setUpVotes($value);
				break;
			case 14:
				$this->setDownVotes($value);
				break;
			case 15:
				$this->setIsGuest($value);
				break;
			case 16:
				$this->setIsAdmin($value);
				break;
			case 17:
				$this->setTodayVotes($value);
				break;
			case 18:
				$this->setEmailOn($value);
				break;
			case 19:
				$this->setLastEmail($value);
				break;
			case 20:
				$this->setCreatedAt($value);
				break;
			case 21:
				$this->setUpdatedAt($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setEmail($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDisplayName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRealName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLocation($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setWebpage($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCountry($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPostalCode($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setBirthday($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setGravatarAddress($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setInfo($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPlatform($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setExperienceScore($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setUpVotes($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setDownVotes($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setIsGuest($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setIsAdmin($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setTodayVotes($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setEmailOn($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setLastEmail($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setCreatedAt($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setUpdatedAt($arr[$keys[21]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
		if ($this->isColumnModified(UserPeer::EMAIL)) $criteria->add(UserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(UserPeer::DISPLAY_NAME)) $criteria->add(UserPeer::DISPLAY_NAME, $this->display_name);
		if ($this->isColumnModified(UserPeer::REAL_NAME)) $criteria->add(UserPeer::REAL_NAME, $this->real_name);
		if ($this->isColumnModified(UserPeer::LOCATION)) $criteria->add(UserPeer::LOCATION, $this->location);
		if ($this->isColumnModified(UserPeer::WEBPAGE)) $criteria->add(UserPeer::WEBPAGE, $this->webpage);
		if ($this->isColumnModified(UserPeer::COUNTRY)) $criteria->add(UserPeer::COUNTRY, $this->country);
		if ($this->isColumnModified(UserPeer::POSTAL_CODE)) $criteria->add(UserPeer::POSTAL_CODE, $this->postal_code);
		if ($this->isColumnModified(UserPeer::BIRTHDAY)) $criteria->add(UserPeer::BIRTHDAY, $this->birthday);
		if ($this->isColumnModified(UserPeer::GRAVATAR_ADDRESS)) $criteria->add(UserPeer::GRAVATAR_ADDRESS, $this->gravatar_address);
		if ($this->isColumnModified(UserPeer::INFO)) $criteria->add(UserPeer::INFO, $this->info);
		if ($this->isColumnModified(UserPeer::PLATFORM)) $criteria->add(UserPeer::PLATFORM, $this->platform);
		if ($this->isColumnModified(UserPeer::EXPERIENCE_SCORE)) $criteria->add(UserPeer::EXPERIENCE_SCORE, $this->experience_score);
		if ($this->isColumnModified(UserPeer::UP_VOTES)) $criteria->add(UserPeer::UP_VOTES, $this->up_votes);
		if ($this->isColumnModified(UserPeer::DOWN_VOTES)) $criteria->add(UserPeer::DOWN_VOTES, $this->down_votes);
		if ($this->isColumnModified(UserPeer::IS_GUEST)) $criteria->add(UserPeer::IS_GUEST, $this->is_guest);
		if ($this->isColumnModified(UserPeer::IS_ADMIN)) $criteria->add(UserPeer::IS_ADMIN, $this->is_admin);
		if ($this->isColumnModified(UserPeer::TODAY_VOTES)) $criteria->add(UserPeer::TODAY_VOTES, $this->today_votes);
		if ($this->isColumnModified(UserPeer::EMAIL_ON)) $criteria->add(UserPeer::EMAIL_ON, $this->email_on);
		if ($this->isColumnModified(UserPeer::LAST_EMAIL)) $criteria->add(UserPeer::LAST_EMAIL, $this->last_email);
		if ($this->isColumnModified(UserPeer::CREATED_AT)) $criteria->add(UserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(UserPeer::UPDATED_AT)) $criteria->add(UserPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of User (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setEmail($this->email);

		$copyObj->setDisplayName($this->display_name);

		$copyObj->setRealName($this->real_name);

		$copyObj->setLocation($this->location);

		$copyObj->setWebpage($this->webpage);

		$copyObj->setCountry($this->country);

		$copyObj->setPostalCode($this->postal_code);

		$copyObj->setBirthday($this->birthday);

		$copyObj->setGravatarAddress($this->gravatar_address);

		$copyObj->setInfo($this->info);

		$copyObj->setPlatform($this->platform);

		$copyObj->setExperienceScore($this->experience_score);

		$copyObj->setUpVotes($this->up_votes);

		$copyObj->setDownVotes($this->down_votes);

		$copyObj->setIsGuest($this->is_guest);

		$copyObj->setIsAdmin($this->is_admin);

		$copyObj->setTodayVotes($this->today_votes);

		$copyObj->setEmailOn($this->email_on);

		$copyObj->setLastEmail($this->last_email);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getUserExperiences() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserExperience($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getOpenids() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addOpenid($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getrpxAuths() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addrpxAuth($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getQuestions() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addQuestion($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getQuestionComments() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addQuestionComment($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getAnswers() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addAnswer($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getAnswerComments() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addAnswerComment($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getQuestionVotes() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addQuestionVote($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getAnswerVotes() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addAnswerVote($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserFavorites() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserFavorite($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserTags() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserTag($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getCheckInformations() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addCheckInformation($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getAnswerOffensives() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addAnswerOffensive($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getQuestionOffensives() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addQuestionOffensive($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserAwards() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserAward($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getMemberReferrals() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addMemberReferral($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGearCompanyInfos() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGearCompanyInfo($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGearInfos() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGearInfo($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGearReviews() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGearReview($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserGears() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserGear($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getOffensives() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addOffensive($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRecentActivitys() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRecentActivity($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     User Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     UserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new UserPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collUserExperiences collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserExperiences()
	 */
	public function clearUserExperiences()
	{
		$this->collUserExperiences = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserExperiences collection (array).
	 *
	 * By default this just sets the collUserExperiences collection to an empty array (like clearcollUserExperiences());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserExperiences()
	{
		$this->collUserExperiences = array();
	}

	/**
	 * Gets an array of UserExperience objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserExperiences from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserExperience[]
	 * @throws     PropelException
	 */
	public function getUserExperiences($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserExperiences === null) {
			if ($this->isNew()) {
			   $this->collUserExperiences = array();
			} else {

				$criteria->add(UserExperiencePeer::USER_ID, $this->id);

				UserExperiencePeer::addSelectColumns($criteria);
				$this->collUserExperiences = UserExperiencePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserExperiencePeer::USER_ID, $this->id);

				UserExperiencePeer::addSelectColumns($criteria);
				if (!isset($this->lastUserExperienceCriteria) || !$this->lastUserExperienceCriteria->equals($criteria)) {
					$this->collUserExperiences = UserExperiencePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserExperienceCriteria = $criteria;
		return $this->collUserExperiences;
	}

	/**
	 * Returns the number of related UserExperience objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserExperience objects.
	 * @throws     PropelException
	 */
	public function countUserExperiences(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserExperiences === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserExperiencePeer::USER_ID, $this->id);

				$count = UserExperiencePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserExperiencePeer::USER_ID, $this->id);

				if (!isset($this->lastUserExperienceCriteria) || !$this->lastUserExperienceCriteria->equals($criteria)) {
					$count = UserExperiencePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collUserExperiences);
				}
			} else {
				$count = count($this->collUserExperiences);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserExperience object to this object
	 * through the UserExperience foreign key attribute.
	 *
	 * @param      UserExperience $l UserExperience
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserExperience(UserExperience $l)
	{
		if ($this->collUserExperiences === null) {
			$this->initUserExperiences();
		}
		if (!in_array($l, $this->collUserExperiences, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserExperiences, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Clears out the collOpenids collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addOpenids()
	 */
	public function clearOpenids()
	{
		$this->collOpenids = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collOpenids collection (array).
	 *
	 * By default this just sets the collOpenids collection to an empty array (like clearcollOpenids());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initOpenids()
	{
		$this->collOpenids = array();
	}

	/**
	 * Gets an array of Openid objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related Openids from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Openid[]
	 * @throws     PropelException
	 */
	public function getOpenids($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOpenids === null) {
			if ($this->isNew()) {
			   $this->collOpenids = array();
			} else {

				$criteria->add(OpenidPeer::USER_ID, $this->id);

				OpenidPeer::addSelectColumns($criteria);
				$this->collOpenids = OpenidPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OpenidPeer::USER_ID, $this->id);

				OpenidPeer::addSelectColumns($criteria);
				if (!isset($this->lastOpenidCriteria) || !$this->lastOpenidCriteria->equals($criteria)) {
					$this->collOpenids = OpenidPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOpenidCriteria = $criteria;
		return $this->collOpenids;
	}

	/**
	 * Returns the number of related Openid objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Openid objects.
	 * @throws     PropelException
	 */
	public function countOpenids(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collOpenids === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(OpenidPeer::USER_ID, $this->id);

				$count = OpenidPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(OpenidPeer::USER_ID, $this->id);

				if (!isset($this->lastOpenidCriteria) || !$this->lastOpenidCriteria->equals($criteria)) {
					$count = OpenidPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collOpenids);
				}
			} else {
				$count = count($this->collOpenids);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Openid object to this object
	 * through the Openid foreign key attribute.
	 *
	 * @param      Openid $l Openid
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOpenid(Openid $l)
	{
		if ($this->collOpenids === null) {
			$this->initOpenids();
		}
		if (!in_array($l, $this->collOpenids, true)) { // only add it if the **same** object is not already associated
			array_push($this->collOpenids, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Clears out the collrpxAuths collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addrpxAuths()
	 */
	public function clearrpxAuths()
	{
		$this->collrpxAuths = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collrpxAuths collection (array).
	 *
	 * By default this just sets the collrpxAuths collection to an empty array (like clearcollrpxAuths());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initrpxAuths()
	{
		$this->collrpxAuths = array();
	}

	/**
	 * Gets an array of rpxAuth objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related rpxAuths from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array rpxAuth[]
	 * @throws     PropelException
	 */
	public function getrpxAuths($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collrpxAuths === null) {
			if ($this->isNew()) {
			   $this->collrpxAuths = array();
			} else {

				$criteria->add(rpxAuthPeer::USER_ID, $this->id);

				rpxAuthPeer::addSelectColumns($criteria);
				$this->collrpxAuths = rpxAuthPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(rpxAuthPeer::USER_ID, $this->id);

				rpxAuthPeer::addSelectColumns($criteria);
				if (!isset($this->lastrpxAuthCriteria) || !$this->lastrpxAuthCriteria->equals($criteria)) {
					$this->collrpxAuths = rpxAuthPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastrpxAuthCriteria = $criteria;
		return $this->collrpxAuths;
	}

	/**
	 * Returns the number of related rpxAuth objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related rpxAuth objects.
	 * @throws     PropelException
	 */
	public function countrpxAuths(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collrpxAuths === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(rpxAuthPeer::USER_ID, $this->id);

				$count = rpxAuthPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(rpxAuthPeer::USER_ID, $this->id);

				if (!isset($this->lastrpxAuthCriteria) || !$this->lastrpxAuthCriteria->equals($criteria)) {
					$count = rpxAuthPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collrpxAuths);
				}
			} else {
				$count = count($this->collrpxAuths);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a rpxAuth object to this object
	 * through the rpxAuth foreign key attribute.
	 *
	 * @param      rpxAuth $l rpxAuth
	 * @return     void
	 * @throws     PropelException
	 */
	public function addrpxAuth(rpxAuth $l)
	{
		if ($this->collrpxAuths === null) {
			$this->initrpxAuths();
		}
		if (!in_array($l, $this->collrpxAuths, true)) { // only add it if the **same** object is not already associated
			array_push($this->collrpxAuths, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Clears out the collQuestions collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addQuestions()
	 */
	public function clearQuestions()
	{
		$this->collQuestions = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collQuestions collection (array).
	 *
	 * By default this just sets the collQuestions collection to an empty array (like clearcollQuestions());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initQuestions()
	{
		$this->collQuestions = array();
	}

	/**
	 * Gets an array of Question objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related Questions from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Question[]
	 * @throws     PropelException
	 */
	public function getQuestions($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestions === null) {
			if ($this->isNew()) {
			   $this->collQuestions = array();
			} else {

				$criteria->add(QuestionPeer::USER_ID, $this->id);

				QuestionPeer::addSelectColumns($criteria);
				$this->collQuestions = QuestionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionPeer::USER_ID, $this->id);

				QuestionPeer::addSelectColumns($criteria);
				if (!isset($this->lastQuestionCriteria) || !$this->lastQuestionCriteria->equals($criteria)) {
					$this->collQuestions = QuestionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastQuestionCriteria = $criteria;
		return $this->collQuestions;
	}

	/**
	 * Returns the number of related Question objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Question objects.
	 * @throws     PropelException
	 */
	public function countQuestions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collQuestions === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(QuestionPeer::USER_ID, $this->id);

				$count = QuestionPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionPeer::USER_ID, $this->id);

				if (!isset($this->lastQuestionCriteria) || !$this->lastQuestionCriteria->equals($criteria)) {
					$count = QuestionPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collQuestions);
				}
			} else {
				$count = count($this->collQuestions);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Question object to this object
	 * through the Question foreign key attribute.
	 *
	 * @param      Question $l Question
	 * @return     void
	 * @throws     PropelException
	 */
	public function addQuestion(Question $l)
	{
		if ($this->collQuestions === null) {
			$this->initQuestions();
		}
		if (!in_array($l, $this->collQuestions, true)) { // only add it if the **same** object is not already associated
			array_push($this->collQuestions, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Clears out the collQuestionComments collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addQuestionComments()
	 */
	public function clearQuestionComments()
	{
		$this->collQuestionComments = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collQuestionComments collection (array).
	 *
	 * By default this just sets the collQuestionComments collection to an empty array (like clearcollQuestionComments());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initQuestionComments()
	{
		$this->collQuestionComments = array();
	}

	/**
	 * Gets an array of QuestionComment objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related QuestionComments from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array QuestionComment[]
	 * @throws     PropelException
	 */
	public function getQuestionComments($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionComments === null) {
			if ($this->isNew()) {
			   $this->collQuestionComments = array();
			} else {

				$criteria->add(QuestionCommentPeer::USER_ID, $this->id);

				QuestionCommentPeer::addSelectColumns($criteria);
				$this->collQuestionComments = QuestionCommentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionCommentPeer::USER_ID, $this->id);

				QuestionCommentPeer::addSelectColumns($criteria);
				if (!isset($this->lastQuestionCommentCriteria) || !$this->lastQuestionCommentCriteria->equals($criteria)) {
					$this->collQuestionComments = QuestionCommentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastQuestionCommentCriteria = $criteria;
		return $this->collQuestionComments;
	}

	/**
	 * Returns the number of related QuestionComment objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related QuestionComment objects.
	 * @throws     PropelException
	 */
	public function countQuestionComments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collQuestionComments === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(QuestionCommentPeer::USER_ID, $this->id);

				$count = QuestionCommentPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionCommentPeer::USER_ID, $this->id);

				if (!isset($this->lastQuestionCommentCriteria) || !$this->lastQuestionCommentCriteria->equals($criteria)) {
					$count = QuestionCommentPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collQuestionComments);
				}
			} else {
				$count = count($this->collQuestionComments);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a QuestionComment object to this object
	 * through the QuestionComment foreign key attribute.
	 *
	 * @param      QuestionComment $l QuestionComment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addQuestionComment(QuestionComment $l)
	{
		if ($this->collQuestionComments === null) {
			$this->initQuestionComments();
		}
		if (!in_array($l, $this->collQuestionComments, true)) { // only add it if the **same** object is not already associated
			array_push($this->collQuestionComments, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related QuestionComments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getQuestionCommentsJoinQuestion($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionComments === null) {
			if ($this->isNew()) {
				$this->collQuestionComments = array();
			} else {

				$criteria->add(QuestionCommentPeer::USER_ID, $this->id);

				$this->collQuestionComments = QuestionCommentPeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(QuestionCommentPeer::USER_ID, $this->id);

			if (!isset($this->lastQuestionCommentCriteria) || !$this->lastQuestionCommentCriteria->equals($criteria)) {
				$this->collQuestionComments = QuestionCommentPeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		}
		$this->lastQuestionCommentCriteria = $criteria;

		return $this->collQuestionComments;
	}

	/**
	 * Clears out the collAnswers collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addAnswers()
	 */
	public function clearAnswers()
	{
		$this->collAnswers = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collAnswers collection (array).
	 *
	 * By default this just sets the collAnswers collection to an empty array (like clearcollAnswers());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initAnswers()
	{
		$this->collAnswers = array();
	}

	/**
	 * Gets an array of Answer objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related Answers from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Answer[]
	 * @throws     PropelException
	 */
	public function getAnswers($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswers === null) {
			if ($this->isNew()) {
			   $this->collAnswers = array();
			} else {

				$criteria->add(AnswerPeer::USER_ID, $this->id);

				AnswerPeer::addSelectColumns($criteria);
				$this->collAnswers = AnswerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AnswerPeer::USER_ID, $this->id);

				AnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastAnswerCriteria) || !$this->lastAnswerCriteria->equals($criteria)) {
					$this->collAnswers = AnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAnswerCriteria = $criteria;
		return $this->collAnswers;
	}

	/**
	 * Returns the number of related Answer objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Answer objects.
	 * @throws     PropelException
	 */
	public function countAnswers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAnswers === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AnswerPeer::USER_ID, $this->id);

				$count = AnswerPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AnswerPeer::USER_ID, $this->id);

				if (!isset($this->lastAnswerCriteria) || !$this->lastAnswerCriteria->equals($criteria)) {
					$count = AnswerPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collAnswers);
				}
			} else {
				$count = count($this->collAnswers);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Answer object to this object
	 * through the Answer foreign key attribute.
	 *
	 * @param      Answer $l Answer
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAnswer(Answer $l)
	{
		if ($this->collAnswers === null) {
			$this->initAnswers();
		}
		if (!in_array($l, $this->collAnswers, true)) { // only add it if the **same** object is not already associated
			array_push($this->collAnswers, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related Answers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getAnswersJoinQuestion($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswers === null) {
			if ($this->isNew()) {
				$this->collAnswers = array();
			} else {

				$criteria->add(AnswerPeer::USER_ID, $this->id);

				$this->collAnswers = AnswerPeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AnswerPeer::USER_ID, $this->id);

			if (!isset($this->lastAnswerCriteria) || !$this->lastAnswerCriteria->equals($criteria)) {
				$this->collAnswers = AnswerPeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		}
		$this->lastAnswerCriteria = $criteria;

		return $this->collAnswers;
	}

	/**
	 * Clears out the collAnswerComments collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addAnswerComments()
	 */
	public function clearAnswerComments()
	{
		$this->collAnswerComments = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collAnswerComments collection (array).
	 *
	 * By default this just sets the collAnswerComments collection to an empty array (like clearcollAnswerComments());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initAnswerComments()
	{
		$this->collAnswerComments = array();
	}

	/**
	 * Gets an array of AnswerComment objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related AnswerComments from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array AnswerComment[]
	 * @throws     PropelException
	 */
	public function getAnswerComments($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswerComments === null) {
			if ($this->isNew()) {
			   $this->collAnswerComments = array();
			} else {

				$criteria->add(AnswerCommentPeer::USER_ID, $this->id);

				AnswerCommentPeer::addSelectColumns($criteria);
				$this->collAnswerComments = AnswerCommentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AnswerCommentPeer::USER_ID, $this->id);

				AnswerCommentPeer::addSelectColumns($criteria);
				if (!isset($this->lastAnswerCommentCriteria) || !$this->lastAnswerCommentCriteria->equals($criteria)) {
					$this->collAnswerComments = AnswerCommentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAnswerCommentCriteria = $criteria;
		return $this->collAnswerComments;
	}

	/**
	 * Returns the number of related AnswerComment objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related AnswerComment objects.
	 * @throws     PropelException
	 */
	public function countAnswerComments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAnswerComments === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AnswerCommentPeer::USER_ID, $this->id);

				$count = AnswerCommentPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AnswerCommentPeer::USER_ID, $this->id);

				if (!isset($this->lastAnswerCommentCriteria) || !$this->lastAnswerCommentCriteria->equals($criteria)) {
					$count = AnswerCommentPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collAnswerComments);
				}
			} else {
				$count = count($this->collAnswerComments);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a AnswerComment object to this object
	 * through the AnswerComment foreign key attribute.
	 *
	 * @param      AnswerComment $l AnswerComment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAnswerComment(AnswerComment $l)
	{
		if ($this->collAnswerComments === null) {
			$this->initAnswerComments();
		}
		if (!in_array($l, $this->collAnswerComments, true)) { // only add it if the **same** object is not already associated
			array_push($this->collAnswerComments, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related AnswerComments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getAnswerCommentsJoinAnswer($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswerComments === null) {
			if ($this->isNew()) {
				$this->collAnswerComments = array();
			} else {

				$criteria->add(AnswerCommentPeer::USER_ID, $this->id);

				$this->collAnswerComments = AnswerCommentPeer::doSelectJoinAnswer($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AnswerCommentPeer::USER_ID, $this->id);

			if (!isset($this->lastAnswerCommentCriteria) || !$this->lastAnswerCommentCriteria->equals($criteria)) {
				$this->collAnswerComments = AnswerCommentPeer::doSelectJoinAnswer($criteria, $con, $join_behavior);
			}
		}
		$this->lastAnswerCommentCriteria = $criteria;

		return $this->collAnswerComments;
	}

	/**
	 * Clears out the collQuestionVotes collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addQuestionVotes()
	 */
	public function clearQuestionVotes()
	{
		$this->collQuestionVotes = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collQuestionVotes collection (array).
	 *
	 * By default this just sets the collQuestionVotes collection to an empty array (like clearcollQuestionVotes());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initQuestionVotes()
	{
		$this->collQuestionVotes = array();
	}

	/**
	 * Gets an array of QuestionVote objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related QuestionVotes from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array QuestionVote[]
	 * @throws     PropelException
	 */
	public function getQuestionVotes($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionVotes === null) {
			if ($this->isNew()) {
			   $this->collQuestionVotes = array();
			} else {

				$criteria->add(QuestionVotePeer::USER_ID, $this->id);

				QuestionVotePeer::addSelectColumns($criteria);
				$this->collQuestionVotes = QuestionVotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionVotePeer::USER_ID, $this->id);

				QuestionVotePeer::addSelectColumns($criteria);
				if (!isset($this->lastQuestionVoteCriteria) || !$this->lastQuestionVoteCriteria->equals($criteria)) {
					$this->collQuestionVotes = QuestionVotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastQuestionVoteCriteria = $criteria;
		return $this->collQuestionVotes;
	}

	/**
	 * Returns the number of related QuestionVote objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related QuestionVote objects.
	 * @throws     PropelException
	 */
	public function countQuestionVotes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collQuestionVotes === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(QuestionVotePeer::USER_ID, $this->id);

				$count = QuestionVotePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionVotePeer::USER_ID, $this->id);

				if (!isset($this->lastQuestionVoteCriteria) || !$this->lastQuestionVoteCriteria->equals($criteria)) {
					$count = QuestionVotePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collQuestionVotes);
				}
			} else {
				$count = count($this->collQuestionVotes);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a QuestionVote object to this object
	 * through the QuestionVote foreign key attribute.
	 *
	 * @param      QuestionVote $l QuestionVote
	 * @return     void
	 * @throws     PropelException
	 */
	public function addQuestionVote(QuestionVote $l)
	{
		if ($this->collQuestionVotes === null) {
			$this->initQuestionVotes();
		}
		if (!in_array($l, $this->collQuestionVotes, true)) { // only add it if the **same** object is not already associated
			array_push($this->collQuestionVotes, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related QuestionVotes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getQuestionVotesJoinQuestion($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionVotes === null) {
			if ($this->isNew()) {
				$this->collQuestionVotes = array();
			} else {

				$criteria->add(QuestionVotePeer::USER_ID, $this->id);

				$this->collQuestionVotes = QuestionVotePeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(QuestionVotePeer::USER_ID, $this->id);

			if (!isset($this->lastQuestionVoteCriteria) || !$this->lastQuestionVoteCriteria->equals($criteria)) {
				$this->collQuestionVotes = QuestionVotePeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		}
		$this->lastQuestionVoteCriteria = $criteria;

		return $this->collQuestionVotes;
	}

	/**
	 * Clears out the collAnswerVotes collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addAnswerVotes()
	 */
	public function clearAnswerVotes()
	{
		$this->collAnswerVotes = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collAnswerVotes collection (array).
	 *
	 * By default this just sets the collAnswerVotes collection to an empty array (like clearcollAnswerVotes());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initAnswerVotes()
	{
		$this->collAnswerVotes = array();
	}

	/**
	 * Gets an array of AnswerVote objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related AnswerVotes from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array AnswerVote[]
	 * @throws     PropelException
	 */
	public function getAnswerVotes($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswerVotes === null) {
			if ($this->isNew()) {
			   $this->collAnswerVotes = array();
			} else {

				$criteria->add(AnswerVotePeer::USER_ID, $this->id);

				AnswerVotePeer::addSelectColumns($criteria);
				$this->collAnswerVotes = AnswerVotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AnswerVotePeer::USER_ID, $this->id);

				AnswerVotePeer::addSelectColumns($criteria);
				if (!isset($this->lastAnswerVoteCriteria) || !$this->lastAnswerVoteCriteria->equals($criteria)) {
					$this->collAnswerVotes = AnswerVotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAnswerVoteCriteria = $criteria;
		return $this->collAnswerVotes;
	}

	/**
	 * Returns the number of related AnswerVote objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related AnswerVote objects.
	 * @throws     PropelException
	 */
	public function countAnswerVotes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAnswerVotes === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AnswerVotePeer::USER_ID, $this->id);

				$count = AnswerVotePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AnswerVotePeer::USER_ID, $this->id);

				if (!isset($this->lastAnswerVoteCriteria) || !$this->lastAnswerVoteCriteria->equals($criteria)) {
					$count = AnswerVotePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collAnswerVotes);
				}
			} else {
				$count = count($this->collAnswerVotes);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a AnswerVote object to this object
	 * through the AnswerVote foreign key attribute.
	 *
	 * @param      AnswerVote $l AnswerVote
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAnswerVote(AnswerVote $l)
	{
		if ($this->collAnswerVotes === null) {
			$this->initAnswerVotes();
		}
		if (!in_array($l, $this->collAnswerVotes, true)) { // only add it if the **same** object is not already associated
			array_push($this->collAnswerVotes, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related AnswerVotes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getAnswerVotesJoinAnswer($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswerVotes === null) {
			if ($this->isNew()) {
				$this->collAnswerVotes = array();
			} else {

				$criteria->add(AnswerVotePeer::USER_ID, $this->id);

				$this->collAnswerVotes = AnswerVotePeer::doSelectJoinAnswer($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AnswerVotePeer::USER_ID, $this->id);

			if (!isset($this->lastAnswerVoteCriteria) || !$this->lastAnswerVoteCriteria->equals($criteria)) {
				$this->collAnswerVotes = AnswerVotePeer::doSelectJoinAnswer($criteria, $con, $join_behavior);
			}
		}
		$this->lastAnswerVoteCriteria = $criteria;

		return $this->collAnswerVotes;
	}

	/**
	 * Clears out the collUserFavorites collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserFavorites()
	 */
	public function clearUserFavorites()
	{
		$this->collUserFavorites = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserFavorites collection (array).
	 *
	 * By default this just sets the collUserFavorites collection to an empty array (like clearcollUserFavorites());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserFavorites()
	{
		$this->collUserFavorites = array();
	}

	/**
	 * Gets an array of UserFavorite objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserFavorites from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserFavorite[]
	 * @throws     PropelException
	 */
	public function getUserFavorites($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserFavorites === null) {
			if ($this->isNew()) {
			   $this->collUserFavorites = array();
			} else {

				$criteria->add(UserFavoritePeer::USER_ID, $this->id);

				UserFavoritePeer::addSelectColumns($criteria);
				$this->collUserFavorites = UserFavoritePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserFavoritePeer::USER_ID, $this->id);

				UserFavoritePeer::addSelectColumns($criteria);
				if (!isset($this->lastUserFavoriteCriteria) || !$this->lastUserFavoriteCriteria->equals($criteria)) {
					$this->collUserFavorites = UserFavoritePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserFavoriteCriteria = $criteria;
		return $this->collUserFavorites;
	}

	/**
	 * Returns the number of related UserFavorite objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserFavorite objects.
	 * @throws     PropelException
	 */
	public function countUserFavorites(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserFavorites === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserFavoritePeer::USER_ID, $this->id);

				$count = UserFavoritePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserFavoritePeer::USER_ID, $this->id);

				if (!isset($this->lastUserFavoriteCriteria) || !$this->lastUserFavoriteCriteria->equals($criteria)) {
					$count = UserFavoritePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collUserFavorites);
				}
			} else {
				$count = count($this->collUserFavorites);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserFavorite object to this object
	 * through the UserFavorite foreign key attribute.
	 *
	 * @param      UserFavorite $l UserFavorite
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserFavorite(UserFavorite $l)
	{
		if ($this->collUserFavorites === null) {
			$this->initUserFavorites();
		}
		if (!in_array($l, $this->collUserFavorites, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserFavorites, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserFavorites from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserFavoritesJoinQuestion($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserFavorites === null) {
			if ($this->isNew()) {
				$this->collUserFavorites = array();
			} else {

				$criteria->add(UserFavoritePeer::USER_ID, $this->id);

				$this->collUserFavorites = UserFavoritePeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserFavoritePeer::USER_ID, $this->id);

			if (!isset($this->lastUserFavoriteCriteria) || !$this->lastUserFavoriteCriteria->equals($criteria)) {
				$this->collUserFavorites = UserFavoritePeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserFavoriteCriteria = $criteria;

		return $this->collUserFavorites;
	}

	/**
	 * Clears out the collUserTags collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserTags()
	 */
	public function clearUserTags()
	{
		$this->collUserTags = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserTags collection (array).
	 *
	 * By default this just sets the collUserTags collection to an empty array (like clearcollUserTags());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserTags()
	{
		$this->collUserTags = array();
	}

	/**
	 * Gets an array of UserTag objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserTags from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserTag[]
	 * @throws     PropelException
	 */
	public function getUserTags($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserTags === null) {
			if ($this->isNew()) {
			   $this->collUserTags = array();
			} else {

				$criteria->add(UserTagPeer::USER_ID, $this->id);

				UserTagPeer::addSelectColumns($criteria);
				$this->collUserTags = UserTagPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserTagPeer::USER_ID, $this->id);

				UserTagPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserTagCriteria) || !$this->lastUserTagCriteria->equals($criteria)) {
					$this->collUserTags = UserTagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserTagCriteria = $criteria;
		return $this->collUserTags;
	}

	/**
	 * Returns the number of related UserTag objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserTag objects.
	 * @throws     PropelException
	 */
	public function countUserTags(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserTags === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserTagPeer::USER_ID, $this->id);

				$count = UserTagPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserTagPeer::USER_ID, $this->id);

				if (!isset($this->lastUserTagCriteria) || !$this->lastUserTagCriteria->equals($criteria)) {
					$count = UserTagPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collUserTags);
				}
			} else {
				$count = count($this->collUserTags);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserTag object to this object
	 * through the UserTag foreign key attribute.
	 *
	 * @param      UserTag $l UserTag
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserTag(UserTag $l)
	{
		if ($this->collUserTags === null) {
			$this->initUserTags();
		}
		if (!in_array($l, $this->collUserTags, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserTags, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserTags from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserTagsJoinTag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserTags === null) {
			if ($this->isNew()) {
				$this->collUserTags = array();
			} else {

				$criteria->add(UserTagPeer::USER_ID, $this->id);

				$this->collUserTags = UserTagPeer::doSelectJoinTag($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserTagPeer::USER_ID, $this->id);

			if (!isset($this->lastUserTagCriteria) || !$this->lastUserTagCriteria->equals($criteria)) {
				$this->collUserTags = UserTagPeer::doSelectJoinTag($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserTagCriteria = $criteria;

		return $this->collUserTags;
	}

	/**
	 * Clears out the collCheckInformations collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addCheckInformations()
	 */
	public function clearCheckInformations()
	{
		$this->collCheckInformations = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collCheckInformations collection (array).
	 *
	 * By default this just sets the collCheckInformations collection to an empty array (like clearcollCheckInformations());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initCheckInformations()
	{
		$this->collCheckInformations = array();
	}

	/**
	 * Gets an array of CheckInformation objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related CheckInformations from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array CheckInformation[]
	 * @throws     PropelException
	 */
	public function getCheckInformations($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCheckInformations === null) {
			if ($this->isNew()) {
			   $this->collCheckInformations = array();
			} else {

				$criteria->add(CheckInformationPeer::USER_ID, $this->id);

				CheckInformationPeer::addSelectColumns($criteria);
				$this->collCheckInformations = CheckInformationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CheckInformationPeer::USER_ID, $this->id);

				CheckInformationPeer::addSelectColumns($criteria);
				if (!isset($this->lastCheckInformationCriteria) || !$this->lastCheckInformationCriteria->equals($criteria)) {
					$this->collCheckInformations = CheckInformationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCheckInformationCriteria = $criteria;
		return $this->collCheckInformations;
	}

	/**
	 * Returns the number of related CheckInformation objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related CheckInformation objects.
	 * @throws     PropelException
	 */
	public function countCheckInformations(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collCheckInformations === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(CheckInformationPeer::USER_ID, $this->id);

				$count = CheckInformationPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(CheckInformationPeer::USER_ID, $this->id);

				if (!isset($this->lastCheckInformationCriteria) || !$this->lastCheckInformationCriteria->equals($criteria)) {
					$count = CheckInformationPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collCheckInformations);
				}
			} else {
				$count = count($this->collCheckInformations);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a CheckInformation object to this object
	 * through the CheckInformation foreign key attribute.
	 *
	 * @param      CheckInformation $l CheckInformation
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCheckInformation(CheckInformation $l)
	{
		if ($this->collCheckInformations === null) {
			$this->initCheckInformations();
		}
		if (!in_array($l, $this->collCheckInformations, true)) { // only add it if the **same** object is not already associated
			array_push($this->collCheckInformations, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related CheckInformations from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getCheckInformationsJoinInformationTemplates($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCheckInformations === null) {
			if ($this->isNew()) {
				$this->collCheckInformations = array();
			} else {

				$criteria->add(CheckInformationPeer::USER_ID, $this->id);

				$this->collCheckInformations = CheckInformationPeer::doSelectJoinInformationTemplates($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(CheckInformationPeer::USER_ID, $this->id);

			if (!isset($this->lastCheckInformationCriteria) || !$this->lastCheckInformationCriteria->equals($criteria)) {
				$this->collCheckInformations = CheckInformationPeer::doSelectJoinInformationTemplates($criteria, $con, $join_behavior);
			}
		}
		$this->lastCheckInformationCriteria = $criteria;

		return $this->collCheckInformations;
	}

	/**
	 * Clears out the collAnswerOffensives collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addAnswerOffensives()
	 */
	public function clearAnswerOffensives()
	{
		$this->collAnswerOffensives = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collAnswerOffensives collection (array).
	 *
	 * By default this just sets the collAnswerOffensives collection to an empty array (like clearcollAnswerOffensives());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initAnswerOffensives()
	{
		$this->collAnswerOffensives = array();
	}

	/**
	 * Gets an array of AnswerOffensive objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related AnswerOffensives from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array AnswerOffensive[]
	 * @throws     PropelException
	 */
	public function getAnswerOffensives($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswerOffensives === null) {
			if ($this->isNew()) {
			   $this->collAnswerOffensives = array();
			} else {

				$criteria->add(AnswerOffensivePeer::USER_ID, $this->id);

				AnswerOffensivePeer::addSelectColumns($criteria);
				$this->collAnswerOffensives = AnswerOffensivePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AnswerOffensivePeer::USER_ID, $this->id);

				AnswerOffensivePeer::addSelectColumns($criteria);
				if (!isset($this->lastAnswerOffensiveCriteria) || !$this->lastAnswerOffensiveCriteria->equals($criteria)) {
					$this->collAnswerOffensives = AnswerOffensivePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAnswerOffensiveCriteria = $criteria;
		return $this->collAnswerOffensives;
	}

	/**
	 * Returns the number of related AnswerOffensive objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related AnswerOffensive objects.
	 * @throws     PropelException
	 */
	public function countAnswerOffensives(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAnswerOffensives === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AnswerOffensivePeer::USER_ID, $this->id);

				$count = AnswerOffensivePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AnswerOffensivePeer::USER_ID, $this->id);

				if (!isset($this->lastAnswerOffensiveCriteria) || !$this->lastAnswerOffensiveCriteria->equals($criteria)) {
					$count = AnswerOffensivePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collAnswerOffensives);
				}
			} else {
				$count = count($this->collAnswerOffensives);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a AnswerOffensive object to this object
	 * through the AnswerOffensive foreign key attribute.
	 *
	 * @param      AnswerOffensive $l AnswerOffensive
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAnswerOffensive(AnswerOffensive $l)
	{
		if ($this->collAnswerOffensives === null) {
			$this->initAnswerOffensives();
		}
		if (!in_array($l, $this->collAnswerOffensives, true)) { // only add it if the **same** object is not already associated
			array_push($this->collAnswerOffensives, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related AnswerOffensives from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getAnswerOffensivesJoinAnswer($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswerOffensives === null) {
			if ($this->isNew()) {
				$this->collAnswerOffensives = array();
			} else {

				$criteria->add(AnswerOffensivePeer::USER_ID, $this->id);

				$this->collAnswerOffensives = AnswerOffensivePeer::doSelectJoinAnswer($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AnswerOffensivePeer::USER_ID, $this->id);

			if (!isset($this->lastAnswerOffensiveCriteria) || !$this->lastAnswerOffensiveCriteria->equals($criteria)) {
				$this->collAnswerOffensives = AnswerOffensivePeer::doSelectJoinAnswer($criteria, $con, $join_behavior);
			}
		}
		$this->lastAnswerOffensiveCriteria = $criteria;

		return $this->collAnswerOffensives;
	}

	/**
	 * Clears out the collQuestionOffensives collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addQuestionOffensives()
	 */
	public function clearQuestionOffensives()
	{
		$this->collQuestionOffensives = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collQuestionOffensives collection (array).
	 *
	 * By default this just sets the collQuestionOffensives collection to an empty array (like clearcollQuestionOffensives());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initQuestionOffensives()
	{
		$this->collQuestionOffensives = array();
	}

	/**
	 * Gets an array of QuestionOffensive objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related QuestionOffensives from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array QuestionOffensive[]
	 * @throws     PropelException
	 */
	public function getQuestionOffensives($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionOffensives === null) {
			if ($this->isNew()) {
			   $this->collQuestionOffensives = array();
			} else {

				$criteria->add(QuestionOffensivePeer::USER_ID, $this->id);

				QuestionOffensivePeer::addSelectColumns($criteria);
				$this->collQuestionOffensives = QuestionOffensivePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionOffensivePeer::USER_ID, $this->id);

				QuestionOffensivePeer::addSelectColumns($criteria);
				if (!isset($this->lastQuestionOffensiveCriteria) || !$this->lastQuestionOffensiveCriteria->equals($criteria)) {
					$this->collQuestionOffensives = QuestionOffensivePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastQuestionOffensiveCriteria = $criteria;
		return $this->collQuestionOffensives;
	}

	/**
	 * Returns the number of related QuestionOffensive objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related QuestionOffensive objects.
	 * @throws     PropelException
	 */
	public function countQuestionOffensives(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collQuestionOffensives === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(QuestionOffensivePeer::USER_ID, $this->id);

				$count = QuestionOffensivePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionOffensivePeer::USER_ID, $this->id);

				if (!isset($this->lastQuestionOffensiveCriteria) || !$this->lastQuestionOffensiveCriteria->equals($criteria)) {
					$count = QuestionOffensivePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collQuestionOffensives);
				}
			} else {
				$count = count($this->collQuestionOffensives);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a QuestionOffensive object to this object
	 * through the QuestionOffensive foreign key attribute.
	 *
	 * @param      QuestionOffensive $l QuestionOffensive
	 * @return     void
	 * @throws     PropelException
	 */
	public function addQuestionOffensive(QuestionOffensive $l)
	{
		if ($this->collQuestionOffensives === null) {
			$this->initQuestionOffensives();
		}
		if (!in_array($l, $this->collQuestionOffensives, true)) { // only add it if the **same** object is not already associated
			array_push($this->collQuestionOffensives, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related QuestionOffensives from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getQuestionOffensivesJoinQuestion($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionOffensives === null) {
			if ($this->isNew()) {
				$this->collQuestionOffensives = array();
			} else {

				$criteria->add(QuestionOffensivePeer::USER_ID, $this->id);

				$this->collQuestionOffensives = QuestionOffensivePeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(QuestionOffensivePeer::USER_ID, $this->id);

			if (!isset($this->lastQuestionOffensiveCriteria) || !$this->lastQuestionOffensiveCriteria->equals($criteria)) {
				$this->collQuestionOffensives = QuestionOffensivePeer::doSelectJoinQuestion($criteria, $con, $join_behavior);
			}
		}
		$this->lastQuestionOffensiveCriteria = $criteria;

		return $this->collQuestionOffensives;
	}

	/**
	 * Clears out the collUserAwards collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserAwards()
	 */
	public function clearUserAwards()
	{
		$this->collUserAwards = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserAwards collection (array).
	 *
	 * By default this just sets the collUserAwards collection to an empty array (like clearcollUserAwards());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserAwards()
	{
		$this->collUserAwards = array();
	}

	/**
	 * Gets an array of UserAward objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserAwards from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserAward[]
	 * @throws     PropelException
	 */
	public function getUserAwards($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserAwards === null) {
			if ($this->isNew()) {
			   $this->collUserAwards = array();
			} else {

				$criteria->add(UserAwardPeer::USER_ID, $this->id);

				UserAwardPeer::addSelectColumns($criteria);
				$this->collUserAwards = UserAwardPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserAwardPeer::USER_ID, $this->id);

				UserAwardPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserAwardCriteria) || !$this->lastUserAwardCriteria->equals($criteria)) {
					$this->collUserAwards = UserAwardPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserAwardCriteria = $criteria;
		return $this->collUserAwards;
	}

	/**
	 * Returns the number of related UserAward objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserAward objects.
	 * @throws     PropelException
	 */
	public function countUserAwards(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserAwards === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserAwardPeer::USER_ID, $this->id);

				$count = UserAwardPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserAwardPeer::USER_ID, $this->id);

				if (!isset($this->lastUserAwardCriteria) || !$this->lastUserAwardCriteria->equals($criteria)) {
					$count = UserAwardPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collUserAwards);
				}
			} else {
				$count = count($this->collUserAwards);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserAward object to this object
	 * through the UserAward foreign key attribute.
	 *
	 * @param      UserAward $l UserAward
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserAward(UserAward $l)
	{
		if ($this->collUserAwards === null) {
			$this->initUserAwards();
		}
		if (!in_array($l, $this->collUserAwards, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserAwards, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserAwards from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserAwardsJoinAward($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserAwards === null) {
			if ($this->isNew()) {
				$this->collUserAwards = array();
			} else {

				$criteria->add(UserAwardPeer::USER_ID, $this->id);

				$this->collUserAwards = UserAwardPeer::doSelectJoinAward($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserAwardPeer::USER_ID, $this->id);

			if (!isset($this->lastUserAwardCriteria) || !$this->lastUserAwardCriteria->equals($criteria)) {
				$this->collUserAwards = UserAwardPeer::doSelectJoinAward($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserAwardCriteria = $criteria;

		return $this->collUserAwards;
	}

	/**
	 * Clears out the collMemberReferrals collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addMemberReferrals()
	 */
	public function clearMemberReferrals()
	{
		$this->collMemberReferrals = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collMemberReferrals collection (array).
	 *
	 * By default this just sets the collMemberReferrals collection to an empty array (like clearcollMemberReferrals());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initMemberReferrals()
	{
		$this->collMemberReferrals = array();
	}

	/**
	 * Gets an array of MemberReferral objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related MemberReferrals from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array MemberReferral[]
	 * @throws     PropelException
	 */
	public function getMemberReferrals($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMemberReferrals === null) {
			if ($this->isNew()) {
			   $this->collMemberReferrals = array();
			} else {

				$criteria->add(MemberReferralPeer::USER_ID, $this->id);

				MemberReferralPeer::addSelectColumns($criteria);
				$this->collMemberReferrals = MemberReferralPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(MemberReferralPeer::USER_ID, $this->id);

				MemberReferralPeer::addSelectColumns($criteria);
				if (!isset($this->lastMemberReferralCriteria) || !$this->lastMemberReferralCriteria->equals($criteria)) {
					$this->collMemberReferrals = MemberReferralPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMemberReferralCriteria = $criteria;
		return $this->collMemberReferrals;
	}

	/**
	 * Returns the number of related MemberReferral objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related MemberReferral objects.
	 * @throws     PropelException
	 */
	public function countMemberReferrals(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collMemberReferrals === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(MemberReferralPeer::USER_ID, $this->id);

				$count = MemberReferralPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(MemberReferralPeer::USER_ID, $this->id);

				if (!isset($this->lastMemberReferralCriteria) || !$this->lastMemberReferralCriteria->equals($criteria)) {
					$count = MemberReferralPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collMemberReferrals);
				}
			} else {
				$count = count($this->collMemberReferrals);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a MemberReferral object to this object
	 * through the MemberReferral foreign key attribute.
	 *
	 * @param      MemberReferral $l MemberReferral
	 * @return     void
	 * @throws     PropelException
	 */
	public function addMemberReferral(MemberReferral $l)
	{
		if ($this->collMemberReferrals === null) {
			$this->initMemberReferrals();
		}
		if (!in_array($l, $this->collMemberReferrals, true)) { // only add it if the **same** object is not already associated
			array_push($this->collMemberReferrals, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Clears out the collGearCompanyInfos collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGearCompanyInfos()
	 */
	public function clearGearCompanyInfos()
	{
		$this->collGearCompanyInfos = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGearCompanyInfos collection (array).
	 *
	 * By default this just sets the collGearCompanyInfos collection to an empty array (like clearcollGearCompanyInfos());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initGearCompanyInfos()
	{
		$this->collGearCompanyInfos = array();
	}

	/**
	 * Gets an array of GearCompanyInfo objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related GearCompanyInfos from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array GearCompanyInfo[]
	 * @throws     PropelException
	 */
	public function getGearCompanyInfos($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearCompanyInfos === null) {
			if ($this->isNew()) {
			   $this->collGearCompanyInfos = array();
			} else {

				$criteria->add(GearCompanyInfoPeer::USER_ID, $this->id);

				GearCompanyInfoPeer::addSelectColumns($criteria);
				$this->collGearCompanyInfos = GearCompanyInfoPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GearCompanyInfoPeer::USER_ID, $this->id);

				GearCompanyInfoPeer::addSelectColumns($criteria);
				if (!isset($this->lastGearCompanyInfoCriteria) || !$this->lastGearCompanyInfoCriteria->equals($criteria)) {
					$this->collGearCompanyInfos = GearCompanyInfoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGearCompanyInfoCriteria = $criteria;
		return $this->collGearCompanyInfos;
	}

	/**
	 * Returns the number of related GearCompanyInfo objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GearCompanyInfo objects.
	 * @throws     PropelException
	 */
	public function countGearCompanyInfos(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collGearCompanyInfos === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(GearCompanyInfoPeer::USER_ID, $this->id);

				$count = GearCompanyInfoPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(GearCompanyInfoPeer::USER_ID, $this->id);

				if (!isset($this->lastGearCompanyInfoCriteria) || !$this->lastGearCompanyInfoCriteria->equals($criteria)) {
					$count = GearCompanyInfoPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collGearCompanyInfos);
				}
			} else {
				$count = count($this->collGearCompanyInfos);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a GearCompanyInfo object to this object
	 * through the GearCompanyInfo foreign key attribute.
	 *
	 * @param      GearCompanyInfo $l GearCompanyInfo
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGearCompanyInfo(GearCompanyInfo $l)
	{
		if ($this->collGearCompanyInfos === null) {
			$this->initGearCompanyInfos();
		}
		if (!in_array($l, $this->collGearCompanyInfos, true)) { // only add it if the **same** object is not already associated
			array_push($this->collGearCompanyInfos, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related GearCompanyInfos from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getGearCompanyInfosJoinGearCompany($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearCompanyInfos === null) {
			if ($this->isNew()) {
				$this->collGearCompanyInfos = array();
			} else {

				$criteria->add(GearCompanyInfoPeer::USER_ID, $this->id);

				$this->collGearCompanyInfos = GearCompanyInfoPeer::doSelectJoinGearCompany($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GearCompanyInfoPeer::USER_ID, $this->id);

			if (!isset($this->lastGearCompanyInfoCriteria) || !$this->lastGearCompanyInfoCriteria->equals($criteria)) {
				$this->collGearCompanyInfos = GearCompanyInfoPeer::doSelectJoinGearCompany($criteria, $con, $join_behavior);
			}
		}
		$this->lastGearCompanyInfoCriteria = $criteria;

		return $this->collGearCompanyInfos;
	}

	/**
	 * Clears out the collGearInfos collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGearInfos()
	 */
	public function clearGearInfos()
	{
		$this->collGearInfos = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGearInfos collection (array).
	 *
	 * By default this just sets the collGearInfos collection to an empty array (like clearcollGearInfos());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initGearInfos()
	{
		$this->collGearInfos = array();
	}

	/**
	 * Gets an array of GearInfo objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related GearInfos from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array GearInfo[]
	 * @throws     PropelException
	 */
	public function getGearInfos($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearInfos === null) {
			if ($this->isNew()) {
			   $this->collGearInfos = array();
			} else {

				$criteria->add(GearInfoPeer::USER_ID, $this->id);

				GearInfoPeer::addSelectColumns($criteria);
				$this->collGearInfos = GearInfoPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GearInfoPeer::USER_ID, $this->id);

				GearInfoPeer::addSelectColumns($criteria);
				if (!isset($this->lastGearInfoCriteria) || !$this->lastGearInfoCriteria->equals($criteria)) {
					$this->collGearInfos = GearInfoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGearInfoCriteria = $criteria;
		return $this->collGearInfos;
	}

	/**
	 * Returns the number of related GearInfo objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GearInfo objects.
	 * @throws     PropelException
	 */
	public function countGearInfos(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collGearInfos === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(GearInfoPeer::USER_ID, $this->id);

				$count = GearInfoPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(GearInfoPeer::USER_ID, $this->id);

				if (!isset($this->lastGearInfoCriteria) || !$this->lastGearInfoCriteria->equals($criteria)) {
					$count = GearInfoPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collGearInfos);
				}
			} else {
				$count = count($this->collGearInfos);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a GearInfo object to this object
	 * through the GearInfo foreign key attribute.
	 *
	 * @param      GearInfo $l GearInfo
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGearInfo(GearInfo $l)
	{
		if ($this->collGearInfos === null) {
			$this->initGearInfos();
		}
		if (!in_array($l, $this->collGearInfos, true)) { // only add it if the **same** object is not already associated
			array_push($this->collGearInfos, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related GearInfos from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getGearInfosJoinGear($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearInfos === null) {
			if ($this->isNew()) {
				$this->collGearInfos = array();
			} else {

				$criteria->add(GearInfoPeer::USER_ID, $this->id);

				$this->collGearInfos = GearInfoPeer::doSelectJoinGear($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GearInfoPeer::USER_ID, $this->id);

			if (!isset($this->lastGearInfoCriteria) || !$this->lastGearInfoCriteria->equals($criteria)) {
				$this->collGearInfos = GearInfoPeer::doSelectJoinGear($criteria, $con, $join_behavior);
			}
		}
		$this->lastGearInfoCriteria = $criteria;

		return $this->collGearInfos;
	}

	/**
	 * Clears out the collGearReviews collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGearReviews()
	 */
	public function clearGearReviews()
	{
		$this->collGearReviews = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGearReviews collection (array).
	 *
	 * By default this just sets the collGearReviews collection to an empty array (like clearcollGearReviews());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initGearReviews()
	{
		$this->collGearReviews = array();
	}

	/**
	 * Gets an array of GearReview objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related GearReviews from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array GearReview[]
	 * @throws     PropelException
	 */
	public function getGearReviews($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearReviews === null) {
			if ($this->isNew()) {
			   $this->collGearReviews = array();
			} else {

				$criteria->add(GearReviewPeer::USER_ID, $this->id);

				GearReviewPeer::addSelectColumns($criteria);
				$this->collGearReviews = GearReviewPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GearReviewPeer::USER_ID, $this->id);

				GearReviewPeer::addSelectColumns($criteria);
				if (!isset($this->lastGearReviewCriteria) || !$this->lastGearReviewCriteria->equals($criteria)) {
					$this->collGearReviews = GearReviewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGearReviewCriteria = $criteria;
		return $this->collGearReviews;
	}

	/**
	 * Returns the number of related GearReview objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GearReview objects.
	 * @throws     PropelException
	 */
	public function countGearReviews(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collGearReviews === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(GearReviewPeer::USER_ID, $this->id);

				$count = GearReviewPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(GearReviewPeer::USER_ID, $this->id);

				if (!isset($this->lastGearReviewCriteria) || !$this->lastGearReviewCriteria->equals($criteria)) {
					$count = GearReviewPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collGearReviews);
				}
			} else {
				$count = count($this->collGearReviews);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a GearReview object to this object
	 * through the GearReview foreign key attribute.
	 *
	 * @param      GearReview $l GearReview
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGearReview(GearReview $l)
	{
		if ($this->collGearReviews === null) {
			$this->initGearReviews();
		}
		if (!in_array($l, $this->collGearReviews, true)) { // only add it if the **same** object is not already associated
			array_push($this->collGearReviews, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related GearReviews from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getGearReviewsJoinGear($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGearReviews === null) {
			if ($this->isNew()) {
				$this->collGearReviews = array();
			} else {

				$criteria->add(GearReviewPeer::USER_ID, $this->id);

				$this->collGearReviews = GearReviewPeer::doSelectJoinGear($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(GearReviewPeer::USER_ID, $this->id);

			if (!isset($this->lastGearReviewCriteria) || !$this->lastGearReviewCriteria->equals($criteria)) {
				$this->collGearReviews = GearReviewPeer::doSelectJoinGear($criteria, $con, $join_behavior);
			}
		}
		$this->lastGearReviewCriteria = $criteria;

		return $this->collGearReviews;
	}

	/**
	 * Clears out the collUserGears collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserGears()
	 */
	public function clearUserGears()
	{
		$this->collUserGears = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserGears collection (array).
	 *
	 * By default this just sets the collUserGears collection to an empty array (like clearcollUserGears());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserGears()
	{
		$this->collUserGears = array();
	}

	/**
	 * Gets an array of UserGear objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related UserGears from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserGear[]
	 * @throws     PropelException
	 */
	public function getUserGears($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserGears === null) {
			if ($this->isNew()) {
			   $this->collUserGears = array();
			} else {

				$criteria->add(UserGearPeer::USER_ID, $this->id);

				UserGearPeer::addSelectColumns($criteria);
				$this->collUserGears = UserGearPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserGearPeer::USER_ID, $this->id);

				UserGearPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserGearCriteria) || !$this->lastUserGearCriteria->equals($criteria)) {
					$this->collUserGears = UserGearPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserGearCriteria = $criteria;
		return $this->collUserGears;
	}

	/**
	 * Returns the number of related UserGear objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserGear objects.
	 * @throws     PropelException
	 */
	public function countUserGears(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserGears === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserGearPeer::USER_ID, $this->id);

				$count = UserGearPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserGearPeer::USER_ID, $this->id);

				if (!isset($this->lastUserGearCriteria) || !$this->lastUserGearCriteria->equals($criteria)) {
					$count = UserGearPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collUserGears);
				}
			} else {
				$count = count($this->collUserGears);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserGear object to this object
	 * through the UserGear foreign key attribute.
	 *
	 * @param      UserGear $l UserGear
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserGear(UserGear $l)
	{
		if ($this->collUserGears === null) {
			$this->initUserGears();
		}
		if (!in_array($l, $this->collUserGears, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserGears, $l);
			$l->setUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserGears from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserGearsJoinGear($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserGears === null) {
			if ($this->isNew()) {
				$this->collUserGears = array();
			} else {

				$criteria->add(UserGearPeer::USER_ID, $this->id);

				$this->collUserGears = UserGearPeer::doSelectJoinGear($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserGearPeer::USER_ID, $this->id);

			if (!isset($this->lastUserGearCriteria) || !$this->lastUserGearCriteria->equals($criteria)) {
				$this->collUserGears = UserGearPeer::doSelectJoinGear($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserGearCriteria = $criteria;

		return $this->collUserGears;
	}

	/**
	 * Clears out the collOffensives collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addOffensives()
	 */
	public function clearOffensives()
	{
		$this->collOffensives = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collOffensives collection (array).
	 *
	 * By default this just sets the collOffensives collection to an empty array (like clearcollOffensives());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initOffensives()
	{
		$this->collOffensives = array();
	}

	/**
	 * Gets an array of Offensive objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related Offensives from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Offensive[]
	 * @throws     PropelException
	 */
	public function getOffensives($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOffensives === null) {
			if ($this->isNew()) {
			   $this->collOffensives = array();
			} else {

				$criteria->add(OffensivePeer::USER_ID, $this->id);

				OffensivePeer::addSelectColumns($criteria);
				$this->collOffensives = OffensivePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(OffensivePeer::USER_ID, $this->id);

				OffensivePeer::addSelectColumns($criteria);
				if (!isset($this->lastOffensiveCriteria) || !$this->lastOffensiveCriteria->equals($criteria)) {
					$this->collOffensives = OffensivePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOffensiveCriteria = $criteria;
		return $this->collOffensives;
	}

	/**
	 * Returns the number of related Offensive objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Offensive objects.
	 * @throws     PropelException
	 */
	public function countOffensives(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collOffensives === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(OffensivePeer::USER_ID, $this->id);

				$count = OffensivePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(OffensivePeer::USER_ID, $this->id);

				if (!isset($this->lastOffensiveCriteria) || !$this->lastOffensiveCriteria->equals($criteria)) {
					$count = OffensivePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collOffensives);
				}
			} else {
				$count = count($this->collOffensives);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Offensive object to this object
	 * through the Offensive foreign key attribute.
	 *
	 * @param      Offensive $l Offensive
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOffensive(Offensive $l)
	{
		if ($this->collOffensives === null) {
			$this->initOffensives();
		}
		if (!in_array($l, $this->collOffensives, true)) { // only add it if the **same** object is not already associated
			array_push($this->collOffensives, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Clears out the collRecentActivitys collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRecentActivitys()
	 */
	public function clearRecentActivitys()
	{
		$this->collRecentActivitys = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRecentActivitys collection (array).
	 *
	 * By default this just sets the collRecentActivitys collection to an empty array (like clearcollRecentActivitys());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initRecentActivitys()
	{
		$this->collRecentActivitys = array();
	}

	/**
	 * Gets an array of RecentActivity objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this User has previously been saved, it will retrieve
	 * related RecentActivitys from storage. If this User is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array RecentActivity[]
	 * @throws     PropelException
	 */
	public function getRecentActivitys($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRecentActivitys === null) {
			if ($this->isNew()) {
			   $this->collRecentActivitys = array();
			} else {

				$criteria->add(RecentActivityPeer::USER_ID, $this->id);

				RecentActivityPeer::addSelectColumns($criteria);
				$this->collRecentActivitys = RecentActivityPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(RecentActivityPeer::USER_ID, $this->id);

				RecentActivityPeer::addSelectColumns($criteria);
				if (!isset($this->lastRecentActivityCriteria) || !$this->lastRecentActivityCriteria->equals($criteria)) {
					$this->collRecentActivitys = RecentActivityPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRecentActivityCriteria = $criteria;
		return $this->collRecentActivitys;
	}

	/**
	 * Returns the number of related RecentActivity objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related RecentActivity objects.
	 * @throws     PropelException
	 */
	public function countRecentActivitys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collRecentActivitys === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(RecentActivityPeer::USER_ID, $this->id);

				$count = RecentActivityPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(RecentActivityPeer::USER_ID, $this->id);

				if (!isset($this->lastRecentActivityCriteria) || !$this->lastRecentActivityCriteria->equals($criteria)) {
					$count = RecentActivityPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collRecentActivitys);
				}
			} else {
				$count = count($this->collRecentActivitys);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a RecentActivity object to this object
	 * through the RecentActivity foreign key attribute.
	 *
	 * @param      RecentActivity $l RecentActivity
	 * @return     void
	 * @throws     PropelException
	 */
	public function addRecentActivity(RecentActivity $l)
	{
		if ($this->collRecentActivitys === null) {
			$this->initRecentActivitys();
		}
		if (!in_array($l, $this->collRecentActivitys, true)) { // only add it if the **same** object is not already associated
			array_push($this->collRecentActivitys, $l);
			$l->setUser($this);
		}
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collUserExperiences) {
				foreach ((array) $this->collUserExperiences as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collOpenids) {
				foreach ((array) $this->collOpenids as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collrpxAuths) {
				foreach ((array) $this->collrpxAuths as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collQuestions) {
				foreach ((array) $this->collQuestions as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collQuestionComments) {
				foreach ((array) $this->collQuestionComments as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collAnswers) {
				foreach ((array) $this->collAnswers as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collAnswerComments) {
				foreach ((array) $this->collAnswerComments as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collQuestionVotes) {
				foreach ((array) $this->collQuestionVotes as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collAnswerVotes) {
				foreach ((array) $this->collAnswerVotes as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserFavorites) {
				foreach ((array) $this->collUserFavorites as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserTags) {
				foreach ((array) $this->collUserTags as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collCheckInformations) {
				foreach ((array) $this->collCheckInformations as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collAnswerOffensives) {
				foreach ((array) $this->collAnswerOffensives as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collQuestionOffensives) {
				foreach ((array) $this->collQuestionOffensives as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserAwards) {
				foreach ((array) $this->collUserAwards as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collMemberReferrals) {
				foreach ((array) $this->collMemberReferrals as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGearCompanyInfos) {
				foreach ((array) $this->collGearCompanyInfos as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGearInfos) {
				foreach ((array) $this->collGearInfos as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGearReviews) {
				foreach ((array) $this->collGearReviews as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserGears) {
				foreach ((array) $this->collUserGears as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collOffensives) {
				foreach ((array) $this->collOffensives as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRecentActivitys) {
				foreach ((array) $this->collRecentActivitys as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collUserExperiences = null;
		$this->collOpenids = null;
		$this->collrpxAuths = null;
		$this->collQuestions = null;
		$this->collQuestionComments = null;
		$this->collAnswers = null;
		$this->collAnswerComments = null;
		$this->collQuestionVotes = null;
		$this->collAnswerVotes = null;
		$this->collUserFavorites = null;
		$this->collUserTags = null;
		$this->collCheckInformations = null;
		$this->collAnswerOffensives = null;
		$this->collQuestionOffensives = null;
		$this->collUserAwards = null;
		$this->collMemberReferrals = null;
		$this->collGearCompanyInfos = null;
		$this->collGearInfos = null;
		$this->collGearReviews = null;
		$this->collUserGears = null;
		$this->collOffensives = null;
		$this->collRecentActivitys = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseUser:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseUser::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseUser
