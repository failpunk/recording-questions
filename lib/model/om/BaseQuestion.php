<?php

/**
 * Base class that represents a row from the 'question' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseQuestion extends BaseObject  implements Persistent {


  const PEER = 'QuestionPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        QuestionPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;

	/**
	 * The value for the tag_id field.
	 * @var        int
	 */
	protected $tag_id;

	/**
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the offensive field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $offensive;

	/**
	 * The value for the visible field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $visible;

	/**
	 * The value for the locked field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $locked;

	/**
	 * The value for the upvotes field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $upvotes;

	/**
	 * The value for the downvotes field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $downvotes;

	/**
	 * The value for the visited field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $visited;

	/**
	 * The value for the notify_email field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $notify_email;

	/**
	 * The value for the tweeted field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $tweeted;

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
	 * @var        User
	 */
	protected $aUser;

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
	 * @var        array QuestionVote[] Collection to store aggregation of QuestionVote objects.
	 */
	protected $collQuestionVotes;

	/**
	 * @var        Criteria The criteria used to select the current contents of collQuestionVotes.
	 */
	private $lastQuestionVoteCriteria = null;

	/**
	 * @var        array UserFavorite[] Collection to store aggregation of UserFavorite objects.
	 */
	protected $collUserFavorites;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserFavorites.
	 */
	private $lastUserFavoriteCriteria = null;

	/**
	 * @var        array QuestionOffensive[] Collection to store aggregation of QuestionOffensive objects.
	 */
	protected $collQuestionOffensives;

	/**
	 * @var        Criteria The criteria used to select the current contents of collQuestionOffensives.
	 */
	private $lastQuestionOffensiveCriteria = null;

	/**
	 * @var        array QuestionClosed[] Collection to store aggregation of QuestionClosed objects.
	 */
	protected $collQuestionCloseds;

	/**
	 * @var        Criteria The criteria used to select the current contents of collQuestionCloseds.
	 */
	private $lastQuestionClosedCriteria = null;

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
	 * Initializes internal state of BaseQuestion object.
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
		$this->offensive = 0;
		$this->visible = 1;
		$this->locked = 0;
		$this->upvotes = 0;
		$this->downvotes = 0;
		$this->visited = 0;
		$this->notify_email = '';
		$this->tweeted = 0;
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
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * Get the [tag_id] column value.
	 * 
	 * @return     int
	 */
	public function getTagId()
	{
		return $this->tag_id;
	}

	/**
	 * Get the [title] column value.
	 * 
	 * @return     string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Get the [offensive] column value.
	 * 
	 * @return     int
	 */
	public function getOffensive()
	{
		return $this->offensive;
	}

	/**
	 * Get the [visible] column value.
	 * 
	 * @return     int
	 */
	public function getVisible()
	{
		return $this->visible;
	}

	/**
	 * Get the [locked] column value.
	 * 
	 * @return     int
	 */
	public function getLocked()
	{
		return $this->locked;
	}

	/**
	 * Get the [upvotes] column value.
	 * 
	 * @return     int
	 */
	public function getUpvotes()
	{
		return $this->upvotes;
	}

	/**
	 * Get the [downvotes] column value.
	 * 
	 * @return     int
	 */
	public function getDownvotes()
	{
		return $this->downvotes;
	}

	/**
	 * Get the [visited] column value.
	 * 
	 * @return     int
	 */
	public function getVisited()
	{
		return $this->visited;
	}

	/**
	 * Get the [notify_email] column value.
	 * 
	 * @return     string
	 */
	public function getNotifyEmail()
	{
		return $this->notify_email;
	}

	/**
	 * Get the [tweeted] column value.
	 * 
	 * @return     int
	 */
	public function getTweeted()
	{
		return $this->tweeted;
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
	 * @return     Question The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = QuestionPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = QuestionPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [tag_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setTagId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tag_id !== $v) {
			$this->tag_id = $v;
			$this->modifiedColumns[] = QuestionPeer::TAG_ID;
		}

		return $this;
	} // setTagId()

	/**
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setTitle($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = QuestionPeer::TITLE;
		}

		return $this;
	} // setTitle()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = QuestionPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Set the value of [offensive] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setOffensive($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->offensive !== $v || $v === 0) {
			$this->offensive = $v;
			$this->modifiedColumns[] = QuestionPeer::OFFENSIVE;
		}

		return $this;
	} // setOffensive()

	/**
	 * Set the value of [visible] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setVisible($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->visible !== $v || $v === 1) {
			$this->visible = $v;
			$this->modifiedColumns[] = QuestionPeer::VISIBLE;
		}

		return $this;
	} // setVisible()

	/**
	 * Set the value of [locked] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setLocked($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->locked !== $v || $v === 0) {
			$this->locked = $v;
			$this->modifiedColumns[] = QuestionPeer::LOCKED;
		}

		return $this;
	} // setLocked()

	/**
	 * Set the value of [upvotes] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setUpvotes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->upvotes !== $v || $v === 0) {
			$this->upvotes = $v;
			$this->modifiedColumns[] = QuestionPeer::UPVOTES;
		}

		return $this;
	} // setUpvotes()

	/**
	 * Set the value of [downvotes] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setDownvotes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->downvotes !== $v || $v === 0) {
			$this->downvotes = $v;
			$this->modifiedColumns[] = QuestionPeer::DOWNVOTES;
		}

		return $this;
	} // setDownvotes()

	/**
	 * Set the value of [visited] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setVisited($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->visited !== $v || $v === 0) {
			$this->visited = $v;
			$this->modifiedColumns[] = QuestionPeer::VISITED;
		}

		return $this;
	} // setVisited()

	/**
	 * Set the value of [notify_email] column.
	 * 
	 * @param      string $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setNotifyEmail($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->notify_email !== $v || $v === '') {
			$this->notify_email = $v;
			$this->modifiedColumns[] = QuestionPeer::NOTIFY_EMAIL;
		}

		return $this;
	} // setNotifyEmail()

	/**
	 * Set the value of [tweeted] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setTweeted($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tweeted !== $v || $v === 0) {
			$this->tweeted = $v;
			$this->modifiedColumns[] = QuestionPeer::TWEETED;
		}

		return $this;
	} // setTweeted()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Question The current object (for fluent API support)
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
				$this->modifiedColumns[] = QuestionPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Question The current object (for fluent API support)
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
				$this->modifiedColumns[] = QuestionPeer::UPDATED_AT;
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
			if (array_diff($this->modifiedColumns, array(QuestionPeer::OFFENSIVE,QuestionPeer::VISIBLE,QuestionPeer::LOCKED,QuestionPeer::UPVOTES,QuestionPeer::DOWNVOTES,QuestionPeer::VISITED,QuestionPeer::NOTIFY_EMAIL,QuestionPeer::TWEETED))) {
				return false;
			}

			if ($this->offensive !== 0) {
				return false;
			}

			if ($this->visible !== 1) {
				return false;
			}

			if ($this->locked !== 0) {
				return false;
			}

			if ($this->upvotes !== 0) {
				return false;
			}

			if ($this->downvotes !== 0) {
				return false;
			}

			if ($this->visited !== 0) {
				return false;
			}

			if ($this->notify_email !== '') {
				return false;
			}

			if ($this->tweeted !== 0) {
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
			$this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->tag_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->title = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->description = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->offensive = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->visible = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->locked = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->upvotes = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->downvotes = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->visited = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
			$this->notify_email = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->tweeted = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
			$this->created_at = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->updated_at = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 15; // 15 = QuestionPeer::NUM_COLUMNS - QuestionPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Question object", $e);
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

		if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
			$this->aUser = null;
		}
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
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = QuestionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUser = null;
			$this->collQuestionComments = null;
			$this->lastQuestionCommentCriteria = null;

			$this->collAnswers = null;
			$this->lastAnswerCriteria = null;

			$this->collQuestionVotes = null;
			$this->lastQuestionVoteCriteria = null;

			$this->collUserFavorites = null;
			$this->lastUserFavoriteCriteria = null;

			$this->collQuestionOffensives = null;
			$this->lastQuestionOffensiveCriteria = null;

			$this->collQuestionCloseds = null;
			$this->lastQuestionClosedCriteria = null;

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

    foreach (sfMixer::getCallables('BaseQuestion:delete:pre') as $callable)
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
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			QuestionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseQuestion:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseQuestion:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(QuestionPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(QuestionPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseQuestion:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			QuestionPeer::addInstanceToPool($this);
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

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if ($this->aUser->isModified() || $this->aUser->isNew()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = QuestionPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = QuestionPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += QuestionPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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

			if ($this->collQuestionVotes !== null) {
				foreach ($this->collQuestionVotes as $referrerFK) {
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

			if ($this->collQuestionOffensives !== null) {
				foreach ($this->collQuestionOffensives as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collQuestionCloseds !== null) {
				foreach ($this->collQuestionCloseds as $referrerFK) {
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}


			if (($retval = QuestionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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

				if ($this->collQuestionVotes !== null) {
					foreach ($this->collQuestionVotes as $referrerFK) {
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

				if ($this->collQuestionOffensives !== null) {
					foreach ($this->collQuestionOffensives as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collQuestionCloseds !== null) {
					foreach ($this->collQuestionCloseds as $referrerFK) {
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
		$pos = QuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getUserId();
				break;
			case 2:
				return $this->getTagId();
				break;
			case 3:
				return $this->getTitle();
				break;
			case 4:
				return $this->getDescription();
				break;
			case 5:
				return $this->getOffensive();
				break;
			case 6:
				return $this->getVisible();
				break;
			case 7:
				return $this->getLocked();
				break;
			case 8:
				return $this->getUpvotes();
				break;
			case 9:
				return $this->getDownvotes();
				break;
			case 10:
				return $this->getVisited();
				break;
			case 11:
				return $this->getNotifyEmail();
				break;
			case 12:
				return $this->getTweeted();
				break;
			case 13:
				return $this->getCreatedAt();
				break;
			case 14:
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
		$keys = QuestionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getTagId(),
			$keys[3] => $this->getTitle(),
			$keys[4] => $this->getDescription(),
			$keys[5] => $this->getOffensive(),
			$keys[6] => $this->getVisible(),
			$keys[7] => $this->getLocked(),
			$keys[8] => $this->getUpvotes(),
			$keys[9] => $this->getDownvotes(),
			$keys[10] => $this->getVisited(),
			$keys[11] => $this->getNotifyEmail(),
			$keys[12] => $this->getTweeted(),
			$keys[13] => $this->getCreatedAt(),
			$keys[14] => $this->getUpdatedAt(),
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
		$pos = QuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUserId($value);
				break;
			case 2:
				$this->setTagId($value);
				break;
			case 3:
				$this->setTitle($value);
				break;
			case 4:
				$this->setDescription($value);
				break;
			case 5:
				$this->setOffensive($value);
				break;
			case 6:
				$this->setVisible($value);
				break;
			case 7:
				$this->setLocked($value);
				break;
			case 8:
				$this->setUpvotes($value);
				break;
			case 9:
				$this->setDownvotes($value);
				break;
			case 10:
				$this->setVisited($value);
				break;
			case 11:
				$this->setNotifyEmail($value);
				break;
			case 12:
				$this->setTweeted($value);
				break;
			case 13:
				$this->setCreatedAt($value);
				break;
			case 14:
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
		$keys = QuestionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTagId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOffensive($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVisible($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLocked($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpvotes($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDownvotes($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setVisited($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setNotifyEmail($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setTweeted($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCreatedAt($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUpdatedAt($arr[$keys[14]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(QuestionPeer::DATABASE_NAME);

		if ($this->isColumnModified(QuestionPeer::ID)) $criteria->add(QuestionPeer::ID, $this->id);
		if ($this->isColumnModified(QuestionPeer::USER_ID)) $criteria->add(QuestionPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(QuestionPeer::TAG_ID)) $criteria->add(QuestionPeer::TAG_ID, $this->tag_id);
		if ($this->isColumnModified(QuestionPeer::TITLE)) $criteria->add(QuestionPeer::TITLE, $this->title);
		if ($this->isColumnModified(QuestionPeer::DESCRIPTION)) $criteria->add(QuestionPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(QuestionPeer::OFFENSIVE)) $criteria->add(QuestionPeer::OFFENSIVE, $this->offensive);
		if ($this->isColumnModified(QuestionPeer::VISIBLE)) $criteria->add(QuestionPeer::VISIBLE, $this->visible);
		if ($this->isColumnModified(QuestionPeer::LOCKED)) $criteria->add(QuestionPeer::LOCKED, $this->locked);
		if ($this->isColumnModified(QuestionPeer::UPVOTES)) $criteria->add(QuestionPeer::UPVOTES, $this->upvotes);
		if ($this->isColumnModified(QuestionPeer::DOWNVOTES)) $criteria->add(QuestionPeer::DOWNVOTES, $this->downvotes);
		if ($this->isColumnModified(QuestionPeer::VISITED)) $criteria->add(QuestionPeer::VISITED, $this->visited);
		if ($this->isColumnModified(QuestionPeer::NOTIFY_EMAIL)) $criteria->add(QuestionPeer::NOTIFY_EMAIL, $this->notify_email);
		if ($this->isColumnModified(QuestionPeer::TWEETED)) $criteria->add(QuestionPeer::TWEETED, $this->tweeted);
		if ($this->isColumnModified(QuestionPeer::CREATED_AT)) $criteria->add(QuestionPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(QuestionPeer::UPDATED_AT)) $criteria->add(QuestionPeer::UPDATED_AT, $this->updated_at);

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
		$criteria = new Criteria(QuestionPeer::DATABASE_NAME);

		$criteria->add(QuestionPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Question (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setTagId($this->tag_id);

		$copyObj->setTitle($this->title);

		$copyObj->setDescription($this->description);

		$copyObj->setOffensive($this->offensive);

		$copyObj->setVisible($this->visible);

		$copyObj->setLocked($this->locked);

		$copyObj->setUpvotes($this->upvotes);

		$copyObj->setDownvotes($this->downvotes);

		$copyObj->setVisited($this->visited);

		$copyObj->setNotifyEmail($this->notify_email);

		$copyObj->setTweeted($this->tweeted);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

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

			foreach ($this->getQuestionVotes() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addQuestionVote($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserFavorites() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserFavorite($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getQuestionOffensives() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addQuestionOffensive($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getQuestionCloseds() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addQuestionClosed($relObj->copy($deepCopy));
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
	 * @return     Question Clone of current object.
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
	 * @return     QuestionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new QuestionPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Question The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUser(User $v = null)
	{
		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}

		$this->aUser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addQuestion($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUser(PropelPDO $con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
			$c = new Criteria(UserPeer::DATABASE_NAME);
			$c->add(UserPeer::ID, $this->user_id);
			$this->aUser = UserPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUser->addQuestions($this);
			 */
		}
		return $this->aUser;
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
	 * Otherwise if this Question has previously been saved, it will retrieve
	 * related QuestionComments from storage. If this Question is new, it will return
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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionComments === null) {
			if ($this->isNew()) {
			   $this->collQuestionComments = array();
			} else {

				$criteria->add(QuestionCommentPeer::QUESTION_ID, $this->id);

				QuestionCommentPeer::addSelectColumns($criteria);
				$this->collQuestionComments = QuestionCommentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionCommentPeer::QUESTION_ID, $this->id);

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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
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

				$criteria->add(QuestionCommentPeer::QUESTION_ID, $this->id);

				$count = QuestionCommentPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionCommentPeer::QUESTION_ID, $this->id);

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
			$l->setQuestion($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Question is new, it will return
	 * an empty collection; or if this Question has previously
	 * been saved, it will retrieve related QuestionComments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Question.
	 */
	public function getQuestionCommentsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionComments === null) {
			if ($this->isNew()) {
				$this->collQuestionComments = array();
			} else {

				$criteria->add(QuestionCommentPeer::QUESTION_ID, $this->id);

				$this->collQuestionComments = QuestionCommentPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(QuestionCommentPeer::QUESTION_ID, $this->id);

			if (!isset($this->lastQuestionCommentCriteria) || !$this->lastQuestionCommentCriteria->equals($criteria)) {
				$this->collQuestionComments = QuestionCommentPeer::doSelectJoinUser($criteria, $con, $join_behavior);
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
	 * Otherwise if this Question has previously been saved, it will retrieve
	 * related Answers from storage. If this Question is new, it will return
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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswers === null) {
			if ($this->isNew()) {
			   $this->collAnswers = array();
			} else {

				$criteria->add(AnswerPeer::QUESTION_ID, $this->id);

				AnswerPeer::addSelectColumns($criteria);
				$this->collAnswers = AnswerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AnswerPeer::QUESTION_ID, $this->id);

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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
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

				$criteria->add(AnswerPeer::QUESTION_ID, $this->id);

				$count = AnswerPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AnswerPeer::QUESTION_ID, $this->id);

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
			$l->setQuestion($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Question is new, it will return
	 * an empty collection; or if this Question has previously
	 * been saved, it will retrieve related Answers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Question.
	 */
	public function getAnswersJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAnswers === null) {
			if ($this->isNew()) {
				$this->collAnswers = array();
			} else {

				$criteria->add(AnswerPeer::QUESTION_ID, $this->id);

				$this->collAnswers = AnswerPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(AnswerPeer::QUESTION_ID, $this->id);

			if (!isset($this->lastAnswerCriteria) || !$this->lastAnswerCriteria->equals($criteria)) {
				$this->collAnswers = AnswerPeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastAnswerCriteria = $criteria;

		return $this->collAnswers;
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
	 * Otherwise if this Question has previously been saved, it will retrieve
	 * related QuestionVotes from storage. If this Question is new, it will return
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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionVotes === null) {
			if ($this->isNew()) {
			   $this->collQuestionVotes = array();
			} else {

				$criteria->add(QuestionVotePeer::QUESTION_ID, $this->id);

				QuestionVotePeer::addSelectColumns($criteria);
				$this->collQuestionVotes = QuestionVotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionVotePeer::QUESTION_ID, $this->id);

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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
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

				$criteria->add(QuestionVotePeer::QUESTION_ID, $this->id);

				$count = QuestionVotePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionVotePeer::QUESTION_ID, $this->id);

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
			$l->setQuestion($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Question is new, it will return
	 * an empty collection; or if this Question has previously
	 * been saved, it will retrieve related QuestionVotes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Question.
	 */
	public function getQuestionVotesJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionVotes === null) {
			if ($this->isNew()) {
				$this->collQuestionVotes = array();
			} else {

				$criteria->add(QuestionVotePeer::QUESTION_ID, $this->id);

				$this->collQuestionVotes = QuestionVotePeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(QuestionVotePeer::QUESTION_ID, $this->id);

			if (!isset($this->lastQuestionVoteCriteria) || !$this->lastQuestionVoteCriteria->equals($criteria)) {
				$this->collQuestionVotes = QuestionVotePeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastQuestionVoteCriteria = $criteria;

		return $this->collQuestionVotes;
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
	 * Otherwise if this Question has previously been saved, it will retrieve
	 * related UserFavorites from storage. If this Question is new, it will return
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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserFavorites === null) {
			if ($this->isNew()) {
			   $this->collUserFavorites = array();
			} else {

				$criteria->add(UserFavoritePeer::QUESTION_ID, $this->id);

				UserFavoritePeer::addSelectColumns($criteria);
				$this->collUserFavorites = UserFavoritePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserFavoritePeer::QUESTION_ID, $this->id);

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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
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

				$criteria->add(UserFavoritePeer::QUESTION_ID, $this->id);

				$count = UserFavoritePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserFavoritePeer::QUESTION_ID, $this->id);

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
			$l->setQuestion($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Question is new, it will return
	 * an empty collection; or if this Question has previously
	 * been saved, it will retrieve related UserFavorites from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Question.
	 */
	public function getUserFavoritesJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserFavorites === null) {
			if ($this->isNew()) {
				$this->collUserFavorites = array();
			} else {

				$criteria->add(UserFavoritePeer::QUESTION_ID, $this->id);

				$this->collUserFavorites = UserFavoritePeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserFavoritePeer::QUESTION_ID, $this->id);

			if (!isset($this->lastUserFavoriteCriteria) || !$this->lastUserFavoriteCriteria->equals($criteria)) {
				$this->collUserFavorites = UserFavoritePeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserFavoriteCriteria = $criteria;

		return $this->collUserFavorites;
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
	 * Otherwise if this Question has previously been saved, it will retrieve
	 * related QuestionOffensives from storage. If this Question is new, it will return
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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionOffensives === null) {
			if ($this->isNew()) {
			   $this->collQuestionOffensives = array();
			} else {

				$criteria->add(QuestionOffensivePeer::QUESTION_ID, $this->id);

				QuestionOffensivePeer::addSelectColumns($criteria);
				$this->collQuestionOffensives = QuestionOffensivePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionOffensivePeer::QUESTION_ID, $this->id);

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
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
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

				$criteria->add(QuestionOffensivePeer::QUESTION_ID, $this->id);

				$count = QuestionOffensivePeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionOffensivePeer::QUESTION_ID, $this->id);

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
			$l->setQuestion($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Question is new, it will return
	 * an empty collection; or if this Question has previously
	 * been saved, it will retrieve related QuestionOffensives from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Question.
	 */
	public function getQuestionOffensivesJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionOffensives === null) {
			if ($this->isNew()) {
				$this->collQuestionOffensives = array();
			} else {

				$criteria->add(QuestionOffensivePeer::QUESTION_ID, $this->id);

				$this->collQuestionOffensives = QuestionOffensivePeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(QuestionOffensivePeer::QUESTION_ID, $this->id);

			if (!isset($this->lastQuestionOffensiveCriteria) || !$this->lastQuestionOffensiveCriteria->equals($criteria)) {
				$this->collQuestionOffensives = QuestionOffensivePeer::doSelectJoinUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastQuestionOffensiveCriteria = $criteria;

		return $this->collQuestionOffensives;
	}

	/**
	 * Clears out the collQuestionCloseds collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addQuestionCloseds()
	 */
	public function clearQuestionCloseds()
	{
		$this->collQuestionCloseds = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collQuestionCloseds collection (array).
	 *
	 * By default this just sets the collQuestionCloseds collection to an empty array (like clearcollQuestionCloseds());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initQuestionCloseds()
	{
		$this->collQuestionCloseds = array();
	}

	/**
	 * Gets an array of QuestionClosed objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Question has previously been saved, it will retrieve
	 * related QuestionCloseds from storage. If this Question is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array QuestionClosed[]
	 * @throws     PropelException
	 */
	public function getQuestionCloseds($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collQuestionCloseds === null) {
			if ($this->isNew()) {
			   $this->collQuestionCloseds = array();
			} else {

				$criteria->add(QuestionClosedPeer::QUESTION_ID, $this->id);

				QuestionClosedPeer::addSelectColumns($criteria);
				$this->collQuestionCloseds = QuestionClosedPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(QuestionClosedPeer::QUESTION_ID, $this->id);

				QuestionClosedPeer::addSelectColumns($criteria);
				if (!isset($this->lastQuestionClosedCriteria) || !$this->lastQuestionClosedCriteria->equals($criteria)) {
					$this->collQuestionCloseds = QuestionClosedPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastQuestionClosedCriteria = $criteria;
		return $this->collQuestionCloseds;
	}

	/**
	 * Returns the number of related QuestionClosed objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related QuestionClosed objects.
	 * @throws     PropelException
	 */
	public function countQuestionCloseds(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collQuestionCloseds === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(QuestionClosedPeer::QUESTION_ID, $this->id);

				$count = QuestionClosedPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(QuestionClosedPeer::QUESTION_ID, $this->id);

				if (!isset($this->lastQuestionClosedCriteria) || !$this->lastQuestionClosedCriteria->equals($criteria)) {
					$count = QuestionClosedPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collQuestionCloseds);
				}
			} else {
				$count = count($this->collQuestionCloseds);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a QuestionClosed object to this object
	 * through the QuestionClosed foreign key attribute.
	 *
	 * @param      QuestionClosed $l QuestionClosed
	 * @return     void
	 * @throws     PropelException
	 */
	public function addQuestionClosed(QuestionClosed $l)
	{
		if ($this->collQuestionCloseds === null) {
			$this->initQuestionCloseds();
		}
		if (!in_array($l, $this->collQuestionCloseds, true)) { // only add it if the **same** object is not already associated
			array_push($this->collQuestionCloseds, $l);
			$l->setQuestion($this);
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
			if ($this->collQuestionVotes) {
				foreach ((array) $this->collQuestionVotes as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserFavorites) {
				foreach ((array) $this->collUserFavorites as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collQuestionOffensives) {
				foreach ((array) $this->collQuestionOffensives as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collQuestionCloseds) {
				foreach ((array) $this->collQuestionCloseds as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collQuestionComments = null;
		$this->collAnswers = null;
		$this->collQuestionVotes = null;
		$this->collUserFavorites = null;
		$this->collQuestionOffensives = null;
		$this->collQuestionCloseds = null;
			$this->aUser = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseQuestion:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseQuestion::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseQuestion
