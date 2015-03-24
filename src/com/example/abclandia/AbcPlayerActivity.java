package com.example.abclandia;

import java.util.ArrayList;
import java.util.List;

import android.animation.Animator;
import android.animation.Animator.AnimatorListener;
import android.animation.ObjectAnimator;
import android.app.Activity;
import android.content.Intent;
import android.content.res.Configuration;
import android.os.Bundle;
import android.view.GestureDetector;
import android.view.GestureDetector.SimpleOnGestureListener;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterViewFlipper;
import android.widget.TextView;

import com.example.abclandia.audio.Audio;
import com.example.abclandia.graphics.CompleteCardRenderer;
import com.example.abclandia.graphics.Renderer;
import com.frba.abclandia.R;
import com.frba.abclandia.adapters.Adapterprueba;

public class AbcPlayerActivity extends Activity implements View.OnTouchListener {

	private static final int SWIPE_MIN_DISTANCE = 120;
	private static final int SWIPE_THRESHOLD_VELOCITY = 130;
	private static final int FLIP_INTERVAL = 3500;
	
	private AdapterViewFlipper mAdapterViewFlipper;

	private WindowManager mWindowManager;
	private int  width;

	private List<Card> data;
	private ObjectAnimator mInAnimator, mOutAnimator;
	private Audio mAudio;
	AnimatorListener mAnimatorListener;
	TextView lblWord;
	private int mLastIndexView;

	@SuppressWarnings("deprecation")
	private final GestureDetector detector = new GestureDetector(
			new SwipeGestureDetector());

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		mWindowManager = (WindowManager) getSystemService("window");
		
		Configuration config = getResources().getConfiguration();
		if (config.smallestScreenWidthDp >= 720) {
			Renderer.TEXT_LETTER_SIZE = 47;
			Renderer.TEXT_WORD_SIZE = 45;
		} else if (config.smallestScreenWidthDp >= 600) {
			Renderer.TEXT_LETTER_SIZE = 38;
			Renderer.TEXT_WORD_SIZE = 36;
		}
		setContentView(R.layout.abc_player_activity);
		 lblWord = (TextView) findViewById(R.id.lblWord);
	
		mAdapterViewFlipper = (AdapterViewFlipper) this
				.findViewById(R.id.view_flipper);
		loadDataCard();
		mAudio = new Audio(this);
		mAudio.loadWordSounds(data);

		mAdapterViewFlipper.setAdapter(new Adapterprueba(data, this,
				new CompleteCardRenderer(this), R.layout.abc_player_card_view));

		mAdapterViewFlipper.setOnTouchListener(new OnTouchListener() {
			@Override
			public boolean onTouch(final View view, final MotionEvent event) {
				detector.onTouchEvent(event);
				return true;
			}
		});

		findViewById(R.id.play).setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View view) {
				mAudio.playSoundWord(data.get(mAdapterViewFlipper.getDisplayedChild()).getId());
				
				mAdapterViewFlipper.setAutoStart(true);
				mAdapterViewFlipper.setFlipInterval(FLIP_INTERVAL);
				mOutAnimator = new ObjectAnimator();
				mOutAnimator.setPropertyName("translationX");
				mOutAnimator.setFloatValues(0, -width);
//				mInAnimator.addListener(mAnimatorListener);

				mInAnimator = new ObjectAnimator();
				mInAnimator.setPropertyName("translationX");
				mInAnimator.setFloatValues(width, 0);
				mInAnimator.addListener(mAnimatorListener);

				mAdapterViewFlipper.setOutAnimation(mOutAnimator);
				mAdapterViewFlipper.setInAnimation(mInAnimator);
				mAdapterViewFlipper.startFlipping();
				
			}
		});

		findViewById(R.id.stop).setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View view) {
				// stop auto flipping
				mAdapterViewFlipper.stopFlipping();
			}
		});

		mAnimatorListener = new AnimatorListener() {

			@Override
			public void onAnimationStart(Animator animation) {
				// TODO Auto-generated method stub

			}

			@Override
			public void onAnimationRepeat(Animator animation) {
				// TODO Auto-generated method stub

			}

			@Override
			public void onAnimationEnd(Animator animation) {
				int indexView = mAdapterViewFlipper.getDisplayedChild();
				
				lblWord.setText(data.get(indexView).getWord());
				mAudio.playSoundWord(data.get(indexView).getId());
				
				

			}

			@Override
			public void onAnimationCancel(Animator animation) {
				// TODO Auto-generated method stub

			}
		};
	}

	@Override
	public void onWindowFocusChanged(boolean focus) {
		super.onWindowFocusChanged(focus);
		width = mAdapterViewFlipper.getWidth();
		lblWord.setText(data.get(0).getWord());
	}

	private void loadDataCard() {
		data = GameDataStructure.LoadDataCard();
	}

	class SwipeGestureDetector extends SimpleOnGestureListener {
		@Override
		public boolean onFling(MotionEvent e1, MotionEvent e2, float velocityX,
				float velocityY) {
			try {
				mAdapterViewFlipper.getDisplayedChild();
				// right to left swipe
				if (e1.getX() - e2.getX() > SWIPE_MIN_DISTANCE
						&& Math.abs(velocityX) > SWIPE_THRESHOLD_VELOCITY) {

					mOutAnimator = new ObjectAnimator();
					mOutAnimator.setPropertyName("translationX");
					mOutAnimator.setFloatValues(0, -width);

					mInAnimator = new ObjectAnimator();
					mInAnimator.setPropertyName("translationX");
					mInAnimator.setFloatValues(width, 0);
					mInAnimator.addListener(mAnimatorListener);

					mAdapterViewFlipper.setOutAnimation(mOutAnimator);
					mAdapterViewFlipper.setInAnimation(mInAnimator);

					mAdapterViewFlipper.showNext();
					return true;
				} else if (e2.getX() - e1.getX() > SWIPE_MIN_DISTANCE
						&& Math.abs(velocityX) > SWIPE_THRESHOLD_VELOCITY) {

					mOutAnimator = new ObjectAnimator();
					mOutAnimator.setPropertyName("translationX");
					mOutAnimator.setFloatValues(0, width);

					mInAnimator = new ObjectAnimator();
					mInAnimator.setPropertyName("translationX");
					mInAnimator.setFloatValues(-width, 0);
					mInAnimator.addListener(mAnimatorListener);

					mAdapterViewFlipper.setOutAnimation(mOutAnimator);
					mAdapterViewFlipper.setInAnimation(mInAnimator);

					mAdapterViewFlipper.showPrevious();
					return true;
				}

			} catch (Exception e) {
				e.printStackTrace();
			}

			return false;
		}

	}

	@Override
	public boolean onTouch(View v, MotionEvent event) {
		return false;
	}
	

	

}
